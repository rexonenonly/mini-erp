<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','string'],
            'password' => ['required','string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $login = $request->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'email';
        // allow login by email only (spec uses email); keep username field as email
        $credentials = ['email' => $login, 'password' => $request->input('password')];

        $user = \App\Models\User::where('email', $login)->first();
        if ($user && isset($user->is_active) && ! $user->is_active) {
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.'])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // last_login_at updated via Login event listener
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showDashboard()
    {
        $lowStock = \DB::table('stock_balances')
            ->join('products', 'stock_balances.product_id', '=', 'products.id')
            ->join('warehouses', 'stock_balances.warehouse_id', '=', 'warehouses.id')
            ->whereRaw('(stock_balances.on_hand - stock_balances.reserved) < products.min_stock')
            ->select('products.name', 'products.sku', 'warehouses.name as warehouse', 
                     \DB::raw('stock_balances.on_hand - stock_balances.reserved as available'), 
                     'products.min_stock')
            ->orderByRaw('(stock_balances.on_hand - stock_balances.reserved) / NULLIF(products.min_stock, 0)')
            ->limit(10)
            ->get();
        
        $overdueInvoices = \App\Models\Invoice::where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->selectRaw('COUNT(*) as count, SUM(total_amount - COALESCE(paid_amount, 0)) as total')
            ->first();
        
        $salesMTD = \App\Models\SalesOrder::whereYear('order_date', date('Y'))
            ->whereMonth('order_date', date('m'))
            ->selectRaw('COUNT(*) as count, SUM(total_amount) as total')
            ->first();
        
        $salesLastMonth = \App\Models\SalesOrder::whereYear('order_date', date('Y'))
            ->whereMonth('order_date', date('m') - 1)
            ->sum('total_amount');
        
        $pctChange = $salesLastMonth > 0 ? (($salesMTD->total - $salesLastMonth) / $salesLastMonth * 100) : 0;
        
        return view('dashboard.index', compact('lowStock', 'overdueInvoices', 'salesMTD', 'pctChange'));
    }
}
