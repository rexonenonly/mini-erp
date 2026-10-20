<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class ChartOfAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['code' => '11100', 'name' => 'Kas', 'type' => 'asset', 'system_key' => 'cash', 'is_active' => true],
            ['code' => '11200', 'name' => 'Bank', 'type' => 'asset', 'system_key' => 'bank', 'is_active' => true],
            ['code' => '11300', 'name' => 'Persediaan', 'type' => 'asset', 'system_key' => 'inventory', 'is_active' => true],
            ['code' => '11400', 'name' => 'Piutang Usaha', 'type' => 'asset', 'system_key' => 'receivable', 'is_active' => true],
            ['code' => '14900', 'name' => 'GRIR (Goods Receipt - Invoice Receipt)', 'type' => 'asset', 'system_key' => 'grir', 'is_active' => true],
            ['code' => '21100', 'name' => 'Hutang Usaha', 'type' => 'liability', 'system_key' => 'payable', 'is_active' => true],
            ['code' => '41100', 'name' => 'Penjualan', 'type' => 'revenue', 'system_key' => 'sales', 'is_active' => true],
            ['code' => '51100', 'name' => 'Harga Pokok Penjualan', 'type' => 'expense', 'system_key' => 'cogs', 'is_active' => true],
            ['code' => '59900', 'name' => 'Selisih Persediaan', 'type' => 'expense', 'system_key' => 'inventory_adjustment', 'is_active' => true],
        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(
                ['code' => $account['code']],
                $account
            );
        }
    }
}
