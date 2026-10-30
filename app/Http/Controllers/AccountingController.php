<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function ledger(Request $request)
    {
        if (! $request->filled('account_id')) {
            $accounts = Account::where('is_active', true)->orderBy('code')->get();
            return view('accounting.ledger', [
                'account'         => null,
                'lines'           => collect(),
                'startingBalance' => 0,
                'endingBalance'   => 0,
                'accounts'        => $accounts,
            ]);
        }

        $account = Account::findOrFail($request->account_id);

        $lines = JournalLine::with('entry')
            ->where('account_id', $account->id)
            ->join('journal_entries', 'journal_entries.id', '=', 'journal_lines.journal_entry_id')
            ->orderBy('journal_entries.entry_date', 'asc')
            ->orderBy('journal_lines.id', 'asc')
            ->select('journal_lines.*')
            ->get();

        $balance = 0;
        $isDebit = $account->normal_balance === 'debit';

        $lines = $lines->map(function ($line) use (&$balance, $isDebit) {
            $balance += $isDebit
                ? ($line->debit - $line->credit)
                : ($line->credit - $line->debit);
            $line->runningBalance = $balance;
            return $line;
        });

        return view('accounting.ledger', [
            'account'         => $account,
            'lines'           => $lines,
            'startingBalance' => 0,
            'endingBalance'   => $balance,
        ]);
    }

    public function journals()
    {
        $entries = JournalEntry::with(['lines.account', 'creator', 'fiscalPeriod'])
            ->orderBy('entry_date', 'desc')
            ->paginate(50);

        $totals = JournalLine::selectRaw('SUM(debit) as total_debit, SUM(credit) as total_credit')->first();

        return view('accounting.journals', [
            'entries'      => $entries,
            'totalDebit'   => $totals->total_debit ?? 0,
            'totalCredit'  => $totals->total_credit ?? 0,
        ]);
    }
}
