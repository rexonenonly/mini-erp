<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HttpSmokeTest extends TestCase
{
    private function loginAs(string $email): void
    {
        $u = User::where('email', $email)->firstOrFail();
        auth()->login($u);
    }

    private static array $PAGES = [
        'dashboard',
        'master-data.products','master-data.warehouses','master-data.partners','master-data.accounts',
        'inventory.stock','inventory.opname','inventory.transfers',
        'purchasing.orders','purchasing.receipts','purchasing.bills','purchasing.payments',
        'sales.orders','sales.deliveries','sales.invoices','sales.payments',
        'accounting.journals','accounting.ledger','accounting.periods',
        'reports.trial-balance','reports.income-statement','reports.aging','reports.inventory-valuation',
        'system.users','system.roles',
    ];

    private static array $EXPECTED = [
        'owner@minierp.test'      => ['*'],
        'gudang@minierp.test'     => ['dashboard','master-data.products','master-data.warehouses','master-data.partners',
                                      'inventory.stock','inventory.opname','inventory.transfers',
                                      'purchasing.orders','purchasing.receipts','sales.orders','sales.deliveries',
                                      'reports.inventory-valuation'],
        'penjualan@minierp.test'  => ['dashboard','master-data.products','master-data.warehouses','master-data.partners',
                                      'inventory.stock','sales.orders','sales.deliveries','sales.invoices','sales.payments',
                                      'reports.aging'],
        'pembelian@minierp.test'  => ['dashboard','master-data.products','master-data.warehouses','master-data.partners',
                                      'inventory.stock','purchasing.orders','purchasing.receipts','purchasing.bills','purchasing.payments',
                                      'reports.aging'],
        'akuntan@minierp.test'    => ['dashboard','master-data.products','master-data.warehouses','master-data.partners','master-data.accounts',
                                      'inventory.stock','inventory.opname','inventory.transfers',
                                      'purchasing.orders','purchasing.receipts','purchasing.bills','purchasing.payments',
                                      'sales.orders','sales.deliveries','sales.invoices','sales.payments',
                                      'accounting.journals','accounting.ledger','accounting.periods',
                                      'reports.trial-balance','reports.income-statement','reports.aging','reports.inventory-valuation'],
    ];

    public function test_demo_users_access_matrix(): void
    {
        $fails = [];
        foreach (self::$EXPECTED as $email => $allowed) {
            $all = in_array('*', $allowed);
            foreach (self::$PAGES as $route) {
                $this->be(User::where('email', $email)->firstOrFail());
                $code = $this->get(route($route))->getStatusCode();
                $expectOk = $all || in_array($route, $allowed);
                if ($expectOk && $code !== 200) {
                    $fails[] = "$email $route expected 200 got $code";
                }
                if (! $expectOk && $code !== 403) {
                    $fails[] = "$email $route expected 403 got $code";
                }
            }
        }
        $this->assertSame([], $fails, "Mismatches:\n" . implode("\n", $fails));
    }

    public function test_sidebar_shows_only_permitted_items(): void
    {
        // Staf Penjualan: no Master Data accounts / no purchasing / no system
        $this->be(User::where('email', 'penjualan@minierp.test')->firstOrFail());
        $html = $this->get(route('dashboard'))->getContent();
        $this->assertStringContainsString('Sales Order', $html);
        $this->assertStringContainsString('Pengiriman', $html);
        $this->assertStringNotContainsString('Purchase Order', $html);
        $this->assertStringNotContainsString('Tagihan', $html);
        $this->assertStringNotContainsString('Akun</a>', $html);
        $this->assertStringNotContainsString('Pengguna</a>', $html);

        // Owner sees Sistem group
        $this->be(User::where('email', 'owner@minierp.test')->firstOrFail());
        $html2 = $this->get(route('dashboard'))->getContent();
        $this->assertStringContainsString('Pengguna', $html2);
        $this->assertStringContainsString('Role &amp; Izin', $html2);
    }

    public function test_guest_redirects_on_protected_pages(): void
    {
        foreach (['dashboard','system.users','master-data.products','reports.aging'] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
    }
}
