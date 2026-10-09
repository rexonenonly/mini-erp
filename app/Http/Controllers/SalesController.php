<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    private function msg(string $singular, string $action): string
    {
        return ucfirst($singular) . ' berhasil ' . $action;
    }

    private array $config = [
        'sales-orders'      => ['model' => \App\Models\SalesOrder::class,      'singular' => 'sales order'],
        'deliveries'        => ['model' => \App\Models\Delivery::class,         'singular' => 'pengiriman'],
        'invoices'          => ['model' => \App\Models\Invoice::class,          'singular' => 'invoice'],
        'customer-payments' => ['model' => \App\Models\CustomerPayment::class,  'singular' => 'pembayaran'],
    ];

    private function authorizeAction(string $resource, string $action): void
    {
        $perm = match ($action) {
            'index', 'show' => "{$resource}.view",
            'store'         => "{$resource}.create",
            'update'        => "{$resource}.update",
            'destroy'       => "{$resource}.delete",
            default         => "{$resource}.view",
        };
        $this->authorize($perm);
    }

    public function index(string $resource)
    {
        $this->authorizeAction($resource, 'index');
        abort_unless(isset($this->config[$resource]), 404);
        $model = $this->config[$resource]['model'];
        $items = $model::query()->with($this->with($resource))->latest()->paginate(15);
        $total = $model::count();
        return view('sales.' . str_replace('-', '_', $resource), compact('resource', 'items', 'total'));
    }

    public function store(Request $request, string $resource)
    {
        $this->authorizeAction($resource, 'store');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $validated = $request->validate($this->rules($resource));
        if (in_array('created_by', (new ($cfg['model']))->getFillable())) {
            $validated['created_by'] = $request->user()->id;
        }
        
        \DB::transaction(function() use ($cfg, $validated, $request, $resource, &$item) {
            $item = $cfg['model']::create($validated);
            
            if ($request->has('lines') && in_array($resource, ['sales-orders', 'deliveries', 'invoices'])) {
                foreach ($request->lines as $line) {
                    $line['subtotal'] = ($line['qty'] ?? 1) * ($line['unit_price'] ?? $line['unit_cost'] ?? 0);
                    $item->lines()->create($line);
                }
                $totalField = $resource === 'deliveries' ? 'total_value' : 'total_amount';
                $item->update([$totalField => $item->lines()->sum('subtotal')]);
            }
        });
        
        return response()->json(['success' => true, 'message' => $this->msg($cfg['singular'], 'ditambahkan'), 'item' => $item]);
    }

    public function show(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'show');
        abort_unless(isset($this->config[$resource]), 404);
        $item = $this->config[$resource]['model']::with($this->with($resource))->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $this->authorizeAction($resource, 'update');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $item = $cfg['model']::findOrFail($id);
        
        \DB::transaction(function() use ($item, $request, $resource) {
            $item->update($request->validate($this->rules($resource, $item->id)));
            
            if ($request->has('lines') && in_array($resource, ['sales-orders', 'deliveries', 'invoices'])) {
                $item->lines()->delete();
                foreach ($request->lines as $line) {
                    $line['subtotal'] = ($line['qty'] ?? 1) * ($line['unit_price'] ?? $line['unit_cost'] ?? 0);
                    $item->lines()->create($line);
                }
                $totalField = $resource === 'deliveries' ? 'total_value' : 'total_amount';
                $item->update([$totalField => $item->lines()->sum('subtotal')]);
            }
        });
        
        return response()->json(['success' => true, 'message' => $this->msg($cfg['singular'], 'diperbarui'), 'item' => $item]);
    }

    public function destroy(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'destroy');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $cfg['model']::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => $this->msg($cfg['singular'], 'dihapus')]);
    }

    private function with(string $resource): array
    {
        return match ($resource) {
            'sales-orders'      => ['customer:id,code,name', 'warehouse:id,name', 'creator:id,name', 'lines.product:id,sku,name'],
            'deliveries'        => ['salesOrder:id,number', 'customer:id,code,name', 'warehouse:id,name', 'creator:id,name', 'lines.product:id,sku,name'],
            'invoices'          => ['delivery:id,number', 'customer:id,code,name', 'lines.product:id,sku,name'],
            'customer-payments' => ['invoice:id,number', 'customer:id,code,name', 'creator:id,name'],
            default             => [],
        };
    }

    private function rules(string $resource, ?int $id = null): array
    {
        $u = $id ? ",{$id}" : '';
        return match ($resource) {
            'sales-orders' => [
                'number'       => "required|string|max:40|unique:sales_orders,number{$u}",
                'order_date'   => 'required|date',
                'customer_id'  => 'required|exists:partners,id',
                'warehouse_id' => 'required|exists:warehouses,id',
                'total_amount' => 'required|numeric|min:0',
                'status'       => 'required|in:draft,confirmed,partial,completed,cancelled',
                'notes'        => 'nullable|string',
                'lines'        => 'required|array|min:1',
                'lines.*.product_id'  => 'required|exists:products,id',
                'lines.*.qty'         => 'required|numeric|min:0.001',
                'lines.*.unit'        => 'required|string|max:20',
                'lines.*.unit_price'  => 'required|numeric|min:0',
                'lines.*.notes'       => 'nullable|string',
            ],
            'deliveries' => [
                'number'          => "required|string|max:40|unique:deliveries,number{$u}",
                'delivery_date'   => 'required|date',
                'sales_order_id'  => 'nullable|exists:sales_orders,id',
                'customer_id'     => 'required|exists:partners,id',
                'warehouse_id'    => 'required|exists:warehouses,id',
                'total_value'     => 'required|numeric|min:0',
                'status'          => 'required|in:draft,posted,reversed',
                'notes'           => 'nullable|string',
                'lines'           => 'required|array|min:1',
                'lines.*.product_id' => 'required|exists:products,id',
                'lines.*.qty'        => 'required|numeric|min:0.001',
                'lines.*.unit'       => 'required|string|max:20',
                'lines.*.unit_cost'  => 'required|numeric|min:0',
                'lines.*.notes'      => 'nullable|string',
            ],
            'invoices' => [
                'number'       => "required|string|max:40|unique:invoices,number{$u}",
                'invoice_date' => 'required|date',
                'due_date'     => 'nullable|date',
                'delivery_id'  => 'nullable|exists:deliveries,id',
                'customer_id'  => 'required|exists:partners,id',
                'total_amount' => 'required|numeric|min:0',
                'paid_amount'  => 'nullable|numeric|min:0',
                'status'       => 'required|in:open,partial,paid,overdue,reversed',
                'notes'        => 'nullable|string',
                'lines'        => 'required|array|min:1',
                'lines.*.product_id'  => 'nullable|exists:products,id',
                'lines.*.description' => 'required|string',
                'lines.*.qty'         => 'required|numeric|min:0.001',
                'lines.*.unit_price'  => 'required|numeric|min:0',
            ],
            'customer-payments' => [
                'number'       => "required|string|max:40|unique:customer_payments,number{$u}",
                'payment_date' => 'required|date',
                'invoice_id'   => 'nullable|exists:invoices,id',
                'customer_id'  => 'required|exists:partners,id',
                'amount'       => 'required|numeric|min:0',
                'method'       => 'required|in:transfer,cash,check',
                'status'       => 'required|in:draft,posted,reversed',
                'notes'        => 'nullable|string',
            ],
            default => [],
        };
    }
}