<?php

namespace App\Http\Controllers;

class ReportController extends Controller
{
    public function index()
    {
        $tab = request('tab', 'neraca-saldo');
        $allowed = ['neraca-saldo', 'laba-rugi', 'umur-piutang-hutang', 'nilai-persediaan'];
        if (!in_array($tab, $allowed)) {
            $tab = 'neraca-saldo';
        }
        return view('reports.index', compact('tab'));
    }
}
