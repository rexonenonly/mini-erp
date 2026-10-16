<?php

namespace App\Domain\Accounting\Services;

use App\Models\Account;
use App\Models\FiscalPeriod;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Posts journal entries from domain events.
 *
 * Caller must be inside DB::transaction() — the deferred balance-check trigger
 * fires at commit, not here.
 *
 * ponytail: Account resolution by system_key on every call (no per-request cache).
 *           Add query-cache if profiling shows this as hot path.
 */
class JournalPoster
{
    /**
     * Post a balanced journal entry.
     *
     * @param array $lines  [['account_key'|'account_id', 'debit', 'credit', 'partner_id'?, 'description'?], ...]
     *                      Use 'account_key' for system accounts (e.g. 'inventory', 'payable').
     *                      Use 'account_id' for explicit account IDs.
     */
    public function post(
        string $sourceType,
        int $sourceId,
        string $description,
        array $lines,
        \DateTimeInterface $entryDate,
        int $createdBy,
        string $kind = 'posting',
        ?int $reversesEntryId = null,
    ): JournalEntry {
        $period = FiscalPeriod::forDate($entryDate);

        if ($period->isClosed()) {
            throw new RuntimeException('Fiscal period is closed');
        }

        $number = $this->nextNumber($entryDate);

        // Resolve lines and compute total
        $resolvedLines = [];
        $totalDebit    = '0.00';

        foreach ($lines as $line) {
            $accountId = isset($line['account_key'])
                ? $this->resolveAccountId($line['account_key'])
                : $line['account_id'];

            $debit  = number_format((float) ($line['debit'] ?? 0), 2, '.', '');
            $credit = number_format((float) ($line['credit'] ?? 0), 2, '.', '');

            $resolvedLines[] = [
                'account_id'  => $accountId,
                'partner_id'  => $line['partner_id'] ?? null,
                'debit'       => $debit,
                'credit'      => $credit,
                'description' => $line['description'] ?? null,
            ];

            $totalDebit = bcadd($totalDebit, $debit, 2);
        }

        $entry = JournalEntry::create([
            'number'           => $number,
            'entry_date'       => $entryDate->format('Y-m-d'),
            'fiscal_period_id' => $period->id,
            'description'      => $description,
            'source_type'      => $sourceType,
            'source_id'        => $sourceId,
            'kind'             => $kind,
            'reverses_entry_id' => $reversesEntryId,
            'status'           => 'posted',
            'total'            => $totalDebit,
            'created_by'       => $createdBy,
            'created_at'       => now(),
        ]);

        foreach ($resolvedLines as $line) {
            JournalLine::create(['journal_entry_id' => $entry->id, ...$line]);
        }

        return $entry;
    }

    /**
     * Create a reversal: swap debit/credit on all lines, mark original as reversed.
     */
    public function reverse(
        JournalEntry $original,
        \DateTimeInterface $reversalDate,
        int $reversedBy,
        string $description = '',
    ): JournalEntry {
        $lines = $original->lines->map(fn ($l) => [
            'account_id'  => $l->account_id,
            'partner_id'  => $l->partner_id,
            'debit'       => $l->credit,  // swapped
            'credit'      => $l->debit,
            'description' => $l->description,
        ])->all();

        $reversal = $this->post(
            sourceType:      $original->source_type,
            sourceId:        $original->source_id,
            description:     $description ?: "Reversal of {$original->number}",
            lines:           $lines,
            entryDate:       $reversalDate,
            createdBy:       $reversedBy,
            kind:            'reversal',
            reversesEntryId: $original->id,
        );

        // Mark original as reversed (trigger only allows posted→reversed)
        DB::table('journal_entries')
            ->where('id', $original->id)
            ->update(['status' => 'reversed']);

        return $reversal;
    }

    // --- Helpers ---

    /** Lock document_sequences row, increment, return formatted number. */
    private function nextNumber(\DateTimeInterface $date): string
    {
        $period  = $date->format('Ym');  // YYYYMM
        $docType = 'JRN';

        // Upsert: insert with 0 if not exists, then increment
        DB::table('document_sequences')->insertOrIgnore([
            'doc_type'    => $docType,
            'period'      => $period,
            'last_number' => 0,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('document_sequences')
            ->where(['doc_type' => $docType, 'period' => $period])
            ->lockForUpdate()
            ->increment('last_number');

        $seq = DB::table('document_sequences')
            ->where(['doc_type' => $docType, 'period' => $period])
            ->value('last_number');

        // JRN-2026-10-0042
        return sprintf('%s-%s-%s-%04d', $docType, $date->format('Y'), $date->format('m'), $seq);
    }

    /** Resolve system_key to account id. Cached within this instance per key. */
    private array $accountCache = [];

    private function resolveAccountId(string $systemKey): int
    {
        if (!isset($this->accountCache[$systemKey])) {
            $id = Account::where('system_key', $systemKey)->where('is_active', true)->value('id');
            if (!$id) {
                throw new RuntimeException("Account with system_key '{$systemKey}' not found or inactive");
            }
            $this->accountCache[$systemKey] = $id;
        }

        return $this->accountCache[$systemKey];
    }
}
