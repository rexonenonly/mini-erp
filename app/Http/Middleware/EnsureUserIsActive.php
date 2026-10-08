<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EnsureUserIsActive {
    public function handle(Request $request, Closure $next) {
        $user = $request->user();
        if ($user && isset($user->is_active) && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if ($request->expectsJson()) return response()->json(['message' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.'], 403);
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
        }
        return $next($request);
    }
}
