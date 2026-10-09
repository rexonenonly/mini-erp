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
        $item = $model::create($validated);

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
        $item->update($validated);

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
            'purchase-orders' => ['supplier:id,code,name', 'warehouse:id,name', 'creator:id,name'],
            'goods-receipts' => ['purchaseOrder:id,number', 'supplier:id,code,name', 'warehouse:id,name', 'creator:id,name'],
            'vendor-bills' => ['receipt:id,number', 'supplier:id,code,name'],
            'supplier-payments' => ['bill:id,number', 'supplier:id,code,name', 'creator:id,name'],
            default => [],
        };
    }

    private function rules(string $resource, ?int $id = null): array
    {
        $unique = $id ? ",{$id}" : '';
        return match ($resource) {
            'purchase-orders' => [
                'number' => "required|string|max:40|unique:purchase_orders,number{$unique}",
                'order_date' => 'required|date',
                'supplier_id' => 'required|exists:partners,id',
                'warehouse_id' => 'required|exists:warehouses,id',
                'total_amount' => 'required|numeric|min:0',
                'status' => 'required|in:draft,confirmed,partial,completed,cancelled',
                'notes' => 'nullable|string',
            ],
            'goods-receipts' => [
                'number' => "required|string|max:40|unique:goods_receipts,number{$unique}",
                'receipt_date' => 'required|date',
                'purchase_order_id' => 'nullable|exists:purchase_orders,id',
                'supplier_id' => 'required|exists:partners,id',
                'warehouse_id' => 'required|exists:warehouses,id',
                'total_value' => 'required|numeric|min:0',
                'status' => 'required|in:draft,posted,reversed',
                'notes' => 'nullable|string',
            ],
            'vendor-bills' => [
                'number' => "required|string|max:40|unique:vendor_bills,number{$unique}",
                'bill_date' => 'required|date',
                'due_date' => 'nullable|date',
                'receipt_id' => 'nullable|exists:goods_receipts,id',
                'supplier_id' => 'required|exists:partners,id',
                'total_amount' => 'required|numeric|min:0',
                'paid_amount' => 'nullable|numeric|min:0',
                'status' => 'required|in:open,partial,paid,reversed',
                'notes' => 'nullable|string',
            ],
            'supplier-payments' => [
                'number' => "required|string|max:40|unique:supplier_payments,number{$unique}",
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
    }
}