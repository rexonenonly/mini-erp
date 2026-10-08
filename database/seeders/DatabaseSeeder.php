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
    public function run(): void
    {
        $this->call([RolePermissionSeeder::class, MasterDataSeeder::class]);

        if (User::count() === 0) {
            User::factory()->create(['name' => 'Test User','email' => 'test@example.com']);
        }

        if (Schema::hasTable('accounts')) {
            DB::table('accounts')->updateOrInsert(['code' => '11110'], ['name' => 'Bank', 'type' => 'asset', 'is_active' => true]);
        } elseif (Schema::hasTable('chart_of_accounts')) {
            DB::table('chart_of_accounts')->updateOrInsert(['code' => '11110'], ['name' => 'Bank', 'type' => 'asset', 'is_active' => true]);
        }
    }
}
