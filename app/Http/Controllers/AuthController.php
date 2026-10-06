<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showDashboard()
    {
        return view('dashboard');
    }
}
