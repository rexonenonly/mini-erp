<?php

namespace App\Http\Controllers;

use App\Models\StockBalance;
use App\Models\Product;
use Illuminate\Http\Request;

class StockBalanceController extends Controller
{
    public function index()
    {
        $this->authorize('stock.view');

        $balances = StockBalance::with(['product:id,sku,name,unit,min_stock', 'warehouse:id,name'])
            ->orderByRaw('GREATEST(on_hand - reserved, 0) DESC')
            ->paginate(15);

        $total = StockBalance::count();

        return view('inventory.stock', compact('balances', 'total'));
    }

    public function show(int $id)
    {
        $this->authorize('stock.view');

        return response()->json(
            StockBalance::with(['product:id,sku,name,unit,min_stock', 'warehouse:id,name'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $this->authorize('stock.create');

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'on_hand' => 'required|numeric|min:0',
            'reserved' => 'nullable|numeric|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
        ]);

        $row = StockBalance::updateOrCreate(
            ['product_id' => $validated['product_id'], 'warehouse_id' => $validated['warehouse_id']],
            [
                'on_hand' => $validated['on_hand'],
                'reserved' => $validated['reserved'] ?? 0,
                'unit_cost' => $validated['unit_cost'] ?? 0,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Saldo stok berhasil disimpan',
            'item' => $row->load(['product:id,sku,name,unit,min_stock', 'warehouse:id,name']),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->authorize('stock.update');

        $row = StockBalance::findOrFail($id);

        $validated = $request->validate([
            'on_hand' => 'required|numeric|min:0',
            'reserved' => 'nullable|numeric|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
        ]);

        $row->update([
            'on_hand' => $validated['on_hand'],
            'reserved' => $validated['reserved'] ?? 0,
            'unit_cost' => $validated['unit_cost'] ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saldo stok berhasil diperbarui',
            'item' => $row->fresh(['product:id,sku,name,unit,min_stock', 'warehouse:id,name']),
        ]);
    }
}