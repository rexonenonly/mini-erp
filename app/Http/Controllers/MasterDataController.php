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
            'update', 'destroy' => "{$resource}.update",
            default => "{$resource}.view"
        };
        $this->authorize($permission);
    }

    private array $config = [
        'products' => ['model' => \App\Models\Product::class, 'label' => 'Produk', 'singular' => 'produk'],
        'warehouses' => ['model' => \App\Models\Warehouse::class, 'label' => 'Gudang', 'singular' => 'gudang'],
        'partners' => ['model' => \App\Models\Partner::class, 'label' => 'Mitra', 'singular' => 'mitra'],
        'accounts' => ['model' => \App\Models\Account::class, 'label' => 'Akun', 'singular' => 'akun'],
    ];

    public function index(string $resource)
    {
        $this->authorizeAction($resource, 'index');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];
        
        $query = $model::query();
        $items = $query->latest()->paginate(15);
        $total = $model::count();

        return view('master-data.index', compact('resource', 'cfg', 'items', 'total'));
    }

    public function store(Request $request, string $resource)
    {
        $this->authorizeAction($resource, 'store');
        abort_unless(isset($this->config[$resource]), 404);
        $cfg = $this->config[$resource];
        $model = $cfg['model'];

        $validated = $request->validate($this->rules($resource));
        $item = $model::create($validated);

        return response()->json(['success' => true, 'message' => ucfirst($cfg['singular']) . ' berhasil ditambahkan', 'item' => $item]);
    }

    public function show(string $resource, int $id)
    {
        $this->authorizeAction($resource, 'show');
        abort_unless(isset($this->config[$resource]), 404);
        $model = $this->config[$resource]['model'];
        $item = $model::findOrFail($id);
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
            default => [],
        };
    }
}
