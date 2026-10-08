<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterDataController extends Controller
{
    private function authorizeAction(string $resource, string $action): void
    {
        $permission = match($action) {
            'index', 'show' => "{$resource}.view",
            'store' => "{$resource}.create",
            'update' => "{$resource}.update",
            'destroy' => "{$resource}.delete",
            default => "{$resource}.view"
        };
        $this->authorize($permission);
    }

    private array $config = [
        'products' => ['model' => \App\Models\Product::class, 'label' => 'Produk', 'singular' => 'produk'],
        'warehouses' => ['model' => \App\Models\Warehouse::class, 'label' => 'Gudang', 'singular' => 'gudang'],
        'partners' => ['model' => \App\Models\Partner::class, 'label' => 'Mitra', 'singular' => 'mitra'],
        'accounts' => ['model' => \App\Models\Account::class, 'label' => 'Akun', 'singular' => 'akun'],
        'stock-opnames' => ['model' => \App\Models\StockOpname::class, 'label' => 'Opname Stok', 'singular' => 'opname stok'],
        'stock-transfers' => ['model' => \App\Models\StockTransfer::class, 'label' => 'Transfer Stok', 'singular' => 'transfer stok'],
    ];

    public function index(string $resource)
    {
        $this->authorizeAction($resource, 'index');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];
        
        $query = $model::query();
        if (in_array($resource, ['stock-opnames', 'stock-transfers'], true)) {
            $query->withCount('items');
        }
        $items = $query->latest()->paginate(15);
        $total = $model::count();

        if ($resource === 'stock-opnames') {
            $items->load(['warehouse', 'creator']);
            return view('inventory.opname', compact('resource', 'items', 'total'));
        }
        if ($resource === 'stock-transfers') {
            $items->load(['fromWarehouse', 'toWarehouse', 'creator']);
            return view('inventory.transfers', compact('resource', 'items', 'total'));
        }

        return view('master-data.index', compact('resource', 'cfg', 'items', 'total'));
    }

    public function store(Request $request, string $resource)
    {
        $this->authorizeAction($resource, 'store');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];

        $validated = $request->validate($this->rules($resource));
        $validated = $this->withDefaults($resource, $validated, $request);
        $item = $model::create($validated);

        return response()->json(['success' => true, 'message' => ucfirst($cfg['singular']) . ' berhasil ditambahkan', 'item' => $item]);
    }

    public function show(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'show');
        abort_unless(isset($this->config[$resource]), 404);
        $model = $this->config[$resource]['model'];
        $item = $model::findOrFail($id);
        if ($resource === 'stock-opnames') $item->load('warehouse');
        if ($resource === 'stock-transfers') $item->load(['fromWarehouse', 'toWarehouse']);
        return response()->json($item);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $this->authorizeAction($resource, 'update');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];
        $item = $model::findOrFail($id);

        $validated = $request->validate($this->rules($resource, $id));
        $item->update($validated);

        return response()->json(['success' => true, 'message' => ucfirst($cfg['singular']) . ' berhasil diperbarui', 'item' => $item]);
    }

    public function destroy(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'destroy');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];
        $item = $model::findOrFail($id);
        $item->delete();

        return response()->json(['success' => true, 'message' => ucfirst($cfg['singular']) . ' berhasil dihapus']);
    }

    private function withDefaults(string $resource, array $validated, Request $request): array
    {
        if ($resource === 'stock-opnames' || $resource === 'stock-transfers') {
            $validated['created_by'] = $request->user()->id;
            if (($validated['status'] ?? null) === 'posted') {
                $validated['posted_at'] = now();
            }
        }
        return $validated;
    }

    private function rules(string $resource, ?int $id = null): array
    {
        $unique = $id ? ",{$id}" : '';
        return match($resource) {
            'products' => [
                'sku' => "required|string|max:50|unique:products,sku{$unique}",
                'name' => 'required|string|max:255',
                'unit' => 'required|string|max:20',
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'min_stock' => 'required|integer|min:0',
                'is_active' => 'boolean',
            ],
            'warehouses' => [
                'code' => "required|string|max:20|unique:warehouses,code{$unique}",
                'name' => 'required|string|max:255',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'is_active' => 'boolean',
            ],
            'partners' => [
                'code' => "required|string|max:20|unique:partners,code{$unique}",
                'name' => 'required|string|max:255',
                'type' => 'required|in:customer,supplier,both',
                'contact_person' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'is_active' => 'boolean',
            ],
            'accounts' => [
                'code' => "required|string|max:20|unique:accounts,code{$unique}",
                'name' => 'required|string|max:255',
                'type' => 'required|in:asset,liability,equity,revenue,expense',
                'balance' => 'required|numeric',
                'is_active' => 'boolean',
            ],
            'stock-opnames' => [
                'number' => "required|string|max:40|unique:stock_opnames,number{$unique}",
                'opname_date' => 'required|date',
                'warehouse_id' => 'required|exists:warehouses,id',
                'notes' => 'nullable|string',
                'status' => 'required|in:draft,posted,reversed',
            ],
            'stock-transfers' => [
                'number' => "required|string|max:40|unique:stock_transfers,number{$unique}",
                'transfer_date' => 'required|date',
                'from_warehouse_id' => 'required|exists:warehouses,id|different:to_warehouse_id',
                'to_warehouse_id' => 'required|exists:warehouses,id',
                'notes' => 'nullable|string',
                'status' => 'required|in:draft,posted,reversed',
            ],
            default => [],
        };
    }
}
