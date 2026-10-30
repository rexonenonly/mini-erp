<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\SalesOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStock = DB::table('stock_balances')
            ->join('products', 'stock_balances.product_id', '=', 'products.id')
            ->join('warehouses', 'stock_balances.warehouse_id', '=', 'warehouses.id')
            ->whereRaw('(stock_balances.on_hand - stock_balances.reserved) < products.min_stock')
            ->select('products.name', 'products.sku', 'warehouses.name as warehouse',
                     DB::raw('stock_balances.on_hand - stock_balances.reserved as available'),
                     'products.min_stock')
            ->orderByRaw('(stock_balances.on_hand - stock_balances.reserved) / NULLIF(products.min_stock, 0)')
            ->limit(10)
            ->get();

        $overdueInvoices = Invoice::where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->selectRaw('COUNT(*) as count, SUM(total_amount - COALESCE(paid_amount, 0)) as total')
            ->first();

        $salesMTD = SalesOrder::whereYear('order_date', date('Y'))
            ->whereMonth('order_date', date('m'))
            ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
            ->first();

        $salesLastMonth = SalesOrder::whereYear('order_date', now()->subMonth()->year)
            ->whereMonth('order_date', now()->subMonth()->month)
            ->sum('total_amount');

        $pctChange = $salesLastMonth > 0
            ? (($salesMTD->total - $salesLastMonth) / $salesLastMonth * 100)
            : 0;

        return view('dashboard.index', compact('lowStock', 'overdueInvoices', 'salesMTD', 'pctChange'));
    }
}
