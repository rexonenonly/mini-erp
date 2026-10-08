<?php
namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    private function userWithRole(string $role): User
    {
        $u = User::factory()->create(['password'=>Hash::make('password'), 'is_active'=>true]);
        $u->assignRole($role);
        return $u;
    }

    #[DataProvider('navigationAccessProvider')]
    public function test_role_can_access_expected_pages(string $role, array $expect200, array $expect403): void
    {
        $u = $this->userWithRole($role);
        $this->actingAs($u);
        foreach ($expect200 as $route) {
            $this->get(route($route))->assertOk("$role should access $route");
        }
        foreach ($expect403 as $route) {
            $this->get(route($route))->assertForbidden("$role should NOT access $route");
        }
    }

    public static function navigationAccessProvider(): array
    {
        $allPages = [
            'master-data.products','master-data.warehouses','master-data.partners','master-data.accounts',
            'inventory.stock','inventory.opname','inventory.transfers',
            'purchasing.orders','purchasing.receipts','purchasing.bills','purchasing.payments',
            'sales.orders','sales.deliveries','sales.invoices','sales.payments',
            'accounting.journals','accounting.ledger','accounting.periods',
            'reports.trial-balance','reports.income-statement','reports.aging','reports.inventory-valuation',
            'system.users','system.roles',
        ];
        $gudang = array_flip([
            'master-data.products','master-data.warehouses','master-data.partners',
            'inventory.stock','inventory.opname','inventory.transfers',
            'purchasing.orders','purchasing.receipts','sales.orders','sales.deliveries',
            'reports.inventory-valuation',
        ]);
        $penjualan = array_flip([
            'master-data.products','master-data.warehouses','master-data.partners',
            'inventory.stock','sales.orders','sales.deliveries','sales.invoices','sales.payments',
            'reports.aging',
        ]);
        $pembelian = array_flip([
            'master-data.products','master-data.warehouses','master-data.partners',
            'inventory.stock','purchasing.orders','purchasing.receipts','purchasing.bills','purchasing.payments',
            'reports.aging',
        ]);
        $akuntan = array_flip([
            'master-data.products','master-data.warehouses','master-data.partners','master-data.accounts',
            'inventory.stock','inventory.opname','inventory.transfers',
            'purchasing.orders','purchasing.receipts','purchasing.bills','purchasing.payments',
            'sales.orders','sales.deliveries','sales.invoices','sales.payments',
            'accounting.journals','accounting.ledger','accounting.periods',
            'reports.trial-balance','reports.income-statement','reports.aging','reports.inventory-valuation',
        ]);
        $build = function($allowed) use ($allPages) {
            $ok=[]; $no=[];
            foreach ($allPages as $p) {
                if (isset($allowed[$p])) $ok[]=$p; else $no[]=$p;
            }
            return ['ok'=>$ok,'no'=>$no];
        };
        return [
            'Owner' => ['Owner', $allPages, []],
            'Staf Gudang' => ['Staf Gudang', $build($gudang)['ok'], $build($gudang)['no']],
            'Staf Penjualan' => ['Staf Penjualan', $build($penjualan)['ok'], $build($penjualan)['no']],
            'Staf Pembelian' => ['Staf Pembelian', $build($pembelian)['ok'], $build($pembelian)['no']],
            'Akuntan' => ['Akuntan', $build($akuntan)['ok'], $build($akuntan)['no']],
        ];
    }
}
