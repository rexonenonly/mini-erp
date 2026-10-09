<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    private function authorizeAction(string $resource, string $action): void
    {
        $permission = match ($action) {
            'index', 'show' => "{$resource}.view",
            'store' => "{$resource}.create",
            'update' => "{$resource}.update",
            'destroy' => "{$resource}.delete",
            default => "{$resource}.view",
        };
        $this->authorize($permission);
    }

    private function msg(string $singular, string $action): string
    {
        return ucfirst($singular) . ' berhasil ' . $action;
    }

    private array $config = [
        'purchase-orders' => ['model' => \App\Models\PurchaseOrder::class, 'label' => 'Purchase Order', 'singular' => 'purchase order'],
        'goods-receipts' => ['model' => \App\Models\GoodsReceipt::class, 'label' => 'Penerimaan Barang', 'singular' => 'penerimaan'],
        'vendor-bills' => ['model' => \App\Models\VendorBill::class, 'label' => 'Tagihan', 'singular' => 'tagihan'],
        'supplier-payments' => ['model' => \App\Models\SupplierPayment::class, 'label' => 'Pembayaran ke Supplier', 'singular' => 'pembayaran'],
    ];

    public function index(string $resource)
    {
        $this->authorizeAction($resource, 'index');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];

        $items = $model::query()->latest()->paginate(15);
        $total = $model::count();

        return view('purchasing.' . str_replace('-', '_', $resource), compact('resource', 'items', 'total'));
    }

    public function store(Request $request, string $resource)
    {
        $this->authorizeAction($resource, 'store');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];

        $validated = $request->validate($this->rules($resource));
        $validated['created_by'] = $request->user()->id;
        
        // ponytail: auto-generate number if empty
        if (empty($validated['number'])) {
            $validated['number'] = $this->generateNumber($resource);
        }
        
        \DB::transaction(function() use ($model, $validated, $request, $resource, &$item) {
            $item = $model::create($validated);
            
            // Save lines if resource supports it
            if ($request->has('lines') && in_array($resource, ['purchase-orders', 'goods-receipts', 'vendor-bills'])) {
                foreach ($request->lines as $line) {
                    $line['subtotal'] = ($line['qty'] ?? 1) * $line['unit_price'];
                    $item->lines()->create($line);
                }
                // Recalc header total from lines
                $item->update(['total_amount' => $item->lines()->sum('subtotal')]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => $this->msg($cfg['singular'], 'ditambahkan'),
            'item' => $item,
        ]);
    }

    public function show(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'show');
        abort_unless(isset($this->config[$resource]), 404);
        $model = $this->config[$resource]['model'];
        $item = $model::with($this->with($resource))->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $this->authorizeAction($resource, 'update');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];
        $item = $model::with($this->with($resource))->findOrFail($id);

        $validated = $request->validate($this->rules($resource, $id));
        
        \DB::transaction(function() use ($item, $validated, $request, $resource) {
            $item->update($validated);
            
            // Update lines if resource supports it
            if ($request->has('lines') && in_array($resource, ['purchase-orders', 'goods-receipts', 'vendor-bills'])) {
                $item->lines()->delete();
                foreach ($request->lines as $line) {
                    $line['subtotal'] = ($line['qty'] ?? 1) * $line['unit_price'];
                    $item->lines()->create($line);
                }
                $item->update(['total_amount' => $item->lines()->sum('subtotal')]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => $this->msg($cfg['singular'], 'diperbarui'),
            'item' => $item,
        ]);
    }

    public function destroy(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'destroy');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];
        $item = $model::with($this->with($resource))->findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => $this->msg($cfg['singular'], 'dihapus'),
        ]);
    }

    private function with(string $resource): array
    {
        return match ($resource) {
            'purchase-orders' => ['supplier:id,code,name', 'warehouse:id,name', 'creator:id,name', 'lines.product:id,sku,name'],
            'goods-receipts' => ['purchaseOrder:id,number', 'supplier:id,code,name', 'warehouse:id,name', 'creator:id,name', 'lines.product:id,sku,name'],
            'vendor-bills' => ['receipt:id,number', 'supplier:id,code,name', 'lines.product:id,sku,name'],
            'supplier-payments' => ['bill:id,number', 'supplier:id,code,name', 'creator:id,name'],
            default => [],
        };
    }

    private function rules(string $resource, ?int $id = null): array
    {
        $unique = $id ? ",{$id}" : '';
        $baseRules = match ($resource) {
            'purchase-orders' => [
                'number' => "nullable|string|max:40|unique:purchase_orders,number{$unique}",
                'order_date' => 'required|date',
                'supplier_id' => 'required|exists:partners,id',
                'warehouse_id' => 'required|exists:warehouses,id',
                'total_amount' => 'required|numeric|min:0',
                'status' => 'required|in:draft,confirmed,partial,completed,cancelled',
                'notes' => 'nullable|string',
                'lines' => 'required|array|min:1',
                'lines.*.product_id' => 'required|exists:products,id',
                'lines.*.qty' => 'required|numeric|min:0.001',
                'lines.*.unit' => 'required|string|max:20',
                'lines.*.unit_price' => 'required|numeric|min:0',
                'lines.*.notes' => 'nullable|string',
            ],
            'goods-receipts' => [
                'number' => "nullable|string|max:40|unique:goods_receipts,number{$unique}",
                'receipt_date' => 'required|date',
                'purchase_order_id' => 'nullable|exists:purchase_orders,id',
                'supplier_id' => 'required|exists:partners,id',
                'warehouse_id' => 'required|exists:warehouses,id',
                'total_value' => 'required|numeric|min:0',
                'status' => 'required|in:draft,posted,reversed',
                'notes' => 'nullable|string',
                'lines' => 'required|array|min:1',
                'lines.*.product_id' => 'required|exists:products,id',
                'lines.*.qty' => 'required|numeric|min:0.001',
                'lines.*.unit' => 'required|string|max:20',
                'lines.*.unit_cost' => 'required|numeric|min:0',
                'lines.*.notes' => 'nullable|string',
            ],
            'vendor-bills' => [
                'number' => "nullable|string|max:40|unique:vendor_bills,number{$unique}",
                'bill_date' => 'required|date',
                'due_date' => 'nullable|date',
                'receipt_id' => 'nullable|exists:goods_receipts,id',
                'supplier_id' => 'required|exists:partners,id',
                'total_amount' => 'required|numeric|min:0',
                'paid_amount' => 'nullable|numeric|min:0',
                'status' => 'required|in:open,partial,paid,reversed',
                'notes' => 'nullable|string',
                'lines' => 'required|array|min:1',
                'lines.*.product_id' => 'nullable|exists:products,id',
                'lines.*.description' => 'required|string',
                'lines.*.amount' => 'required|numeric|min:0',
            ],
            'supplier-payments' => [
                'number' => "nullable|string|max:40|unique:supplier_payments,number{$unique}",
                'payment_date' => 'required|date',
                'bill_id' => 'nullable|exists:vendor_bills,id',
                'supplier_id' => 'required|exists:partners,id',
                'amount' => 'required|numeric|min:0',
                'method' => 'required|in:transfer,cash,check',
                'status' => 'required|in:draft,posted,reversed',
                'notes' => 'nullable|string',
            ],
            default => [],
        };
        return $baseRules;
    }

    private function generateNumber(string $resource): string
    {
        $prefix = match($resource) {
            'purchase-orders' => 'PO',
            'goods-receipts' => 'GR',
            'vendor-bills' => 'BILL',
            'supplier-payments' => 'PAY-S',
            default => 'DOC',
        };
        $year = date('Y');
        $month = date('m');
        $model = $this->config[$resource]['model'];
        $lastNumber = $model::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->value('number');
        $seq = 1;
        if ($lastNumber && preg_match('/-(\d+)$/', $lastNumber, $m)) {
            $seq = intval($m[1]) + 1;
        }
        return sprintf('%s-%s-%s-%04d', $prefix, $year, $month, $seq);
    }
}