<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function trialBalance()
    {
        $accounts = Account::select('accounts.id', 'accounts.code', 'accounts.name', 'accounts.normal_balance')
            ->selectRaw('COALESCE(SUM(CASE WHEN journal_lines.debit > 0 THEN journal_lines.debit ELSE 0 END), 0) as debit')
            ->selectRaw('COALESCE(SUM(CASE WHEN journal_lines.credit > 0 THEN journal_lines.credit ELSE 0 END), 0) as credit')
            ->leftJoin('journal_lines', 'journal_lines.account_id', '=', 'accounts.id')
            ->where('accounts.is_active', true)
            ->groupBy('accounts.id', 'accounts.code', 'accounts.name', 'accounts.normal_balance')
            ->get()
            ->filter(fn($acc) => $acc->debit != 0 || $acc->credit != 0)
            ->map(function ($acc) {
                $acc->balance = $acc->normal_balance === 'debit'
                    ? $acc->debit - $acc->credit
                    : $acc->credit - $acc->debit;
                return $acc;
            });

        $totalDebit = $accounts->sum('debit');
        $totalCredit = $accounts->sum('credit');
        $isBalanced = $totalDebit == $totalCredit;

        return view('reports.trial-balance', compact('accounts', 'totalDebit', 'totalCredit', 'isBalanced'));
    }

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
