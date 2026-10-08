<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ponytail: 11110 Bank display row — guarded, no accounts table/migration yet (constraint: do not edit existing migrations)
        if (Schema::hasTable('accounts')) {
            DB::table('accounts')->updateOrInsert(['code' => '11110'], ['name' => 'Bank', 'type' => 'Aset', 'normal_balance' => 'Debit', 'is_active' => true]);
        } elseif (Schema::hasTable('chart_of_accounts')) {
            DB::table('chart_of_accounts')->updateOrInsert(['code' => '11110'], ['name' => 'Bank', 'type' => 'Aset', 'normal_balance' => 'Debit', 'is_active' => true]);
        }
    }
}
