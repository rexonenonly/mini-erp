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

    public function showDashboard() { return view('dashboard.index'); }
}
