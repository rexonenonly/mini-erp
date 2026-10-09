<?php

namespace App\Services;

use App\Models\JournalEntry;
use Illuminate\Support\Facades\DB;

class JournalService
{
    // ponytail: hardcoded account IDs — replace with config when multi-company
    const INVENTORY = 1;
    const COGS = 2;
    const SALES = 3;
    const AR = 4;
    const AP = 5;

    public function createFromGoodsReceipt($receipt, $userId)
    {
        return DB::transaction(function() use ($receipt, $userId) {
            $entry = JournalEntry::create([
                'number' => 'JE-' . $receipt->number,
                'entry_date' => $receipt->receipt_date,
                'source_type' => 'GoodsReceipt',
                'source_id' => $receipt->id,
                'description' => "Penerimaan barang {$receipt->number}",
                'status' => 'posted',
                'created_by' => $userId,
                'posted_at' => now(),
            ]);
            $total = $receipt->lines->sum('subtotal');
            $entry->lines()->createMany([
                ['account_id' => self::INVENTORY, 'debit' => $total, 'credit' => 0, 'memo' => 'Inventory'],
                ['account_id' => self::AP, 'debit' => 0, 'credit' => $total, 'memo' => 'Hutang'],
            ]);
            return $entry;
        });
    }

    public function createFromDelivery($delivery, $userId)
    {
        return DB::transaction(function() use ($delivery, $userId) {
            $entry = JournalEntry::create([
                'number' => 'JE-' . $delivery->number,
                'entry_date' => $delivery->delivery_date,
                'source_type' => 'Delivery',
                'source_id' => $delivery->id,
                'description' => "Pengiriman {$delivery->number}",
                'status' => 'posted',
                'created_by' => $userId,
                'posted_at' => now(),
            ]);
            $cogs = $delivery->lines->sum(fn($ln) => $ln->qty * $ln->product->purchase_price);
            $sales = $delivery->lines->sum('subtotal');
            $entry->lines()->createMany([
                ['account_id' => self::COGS, 'debit' => $cogs, 'credit' => 0, 'memo' => 'COGS'],
                ['account_id' => self::INVENTORY, 'debit' => 0, 'credit' => $cogs, 'memo' => 'Inventory keluar'],
                ['account_id' => self::AR, 'debit' => $sales, 'credit' => 0, 'memo' => 'Piutang'],
                ['account_id' => self::SALES, 'debit' => 0, 'credit' => $sales, 'memo' => 'Penjualan'],
            ]);
            return $entry;
        });
    }
}
