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

    public function test_tables_expose_view_edit_delete_actions(): void
    {
        $this->be(User::where('email', 'owner@minierp.test')->firstOrFail());

        $wh = \App\Models\Warehouse::create(['code' => 'W1', 'name' => 'Gudang Uji', 'is_active' => true]);
        $prod = \App\Models\Product::create(['sku' => 'P1', 'name' => 'Produk Uji', 'unit' => 'pcs', 'purchase_price' => 1, 'sale_price' => 1, 'min_stock' => 0, 'is_active' => true]);
        \App\Models\Partner::create(['code' => 'M1', 'name' => 'Mitra Uji', 'type' => 'both', 'is_active' => true]);
        \App\Models\Account::create(['code' => 'A1', 'name' => 'Akun Uji', 'type' => 'asset', 'balance' => 0, 'is_active' => true]);
        \App\Models\StockBalance::create(['product_id' => $prod->id, 'warehouse_id' => $wh->id, 'on_hand' => 10, 'reserved' => 0, 'unit_cost' => 100]);
        \App\Models\StockOpname::create(['number' => 'OP-1', 'opname_date' => now(), 'warehouse_id' => $wh->id, 'status' => 'draft', 'created_by' => auth()->id()]);
        \App\Models\StockTransfer::create(['number' => 'TF-1', 'transfer_date' => now(), 'from_warehouse_id' => $wh->id, 'to_warehouse_id' => $wh->id, 'status' => 'draft', 'created_by' => auth()->id()]);

        foreach (['master-data.products', 'master-data.warehouses', 'master-data.partners', 'master-data.accounts',
                  'inventory.stock', 'inventory.opname', 'inventory.transfers'] as $route) {
            $html = $this->get(route($route))->getContent();
            $this->assertStringContainsString('openModal(\'view\'', $html, "$route: no view action");
            $this->assertStringContainsString('openModal(\'edit\'', $html, "$route: no edit action");
            $this->assertStringContainsString('confirmDelete(', $html, "$route: no delete action");
        }
    }

    public function test_delete_endpoints_authorize_and_remove(): void
    {
        $this->be(User::where('email', 'owner@minierp.test')->firstOrFail());
        $product = \App\Models\Product::create([
            'sku' => 'TEST-DEL-1', 'name' => 'Hapus Saya', 'unit' => 'pcs',
            'purchase_price' => 1, 'sale_price' => 1, 'min_stock' => 0, 'is_active' => true,
        ]);
        $this->delete("/master-data/products/{$product->id}")->assertOk();
        $this->assertNull(\App\Models\Product::find($product->id));

        // Staf Gudang has no delete permission -> 403
        $this->be(User::where('email', 'gudang@minierp.test')->firstOrFail());
        $p2 = \App\Models\Product::create([
            'sku' => 'TEST-DEL-2', 'name' => 'Tetap Ada', 'unit' => 'pcs',
            'purchase_price' => 1, 'sale_price' => 1, 'min_stock' => 0, 'is_active' => true,
        ]);
        $this->delete("/master-data/products/{$p2->id}")->assertForbidden();
        $this->assertNotNull(\App\Models\Product::find($p2->id));
    }

    public function test_no_modal_js_parse_error_in_rendered_html(): void
    {
        $this->be(User::where('email', 'owner@minierp.test')->firstOrFail());
        $html = $this->get(route('master-data.products'))->getContent();
        preg_match_all('/<script(?:[^>]*)>(.*?)<\/script>/s', $html, $m);
        $js = implode("\n", $m[1] ?? []);
        $this->assertStringNotContainsString('->', $js, 'Leaked PHP -> inside JS string');
        $tmp = sys_get_temp_dir() . '/modal-js-' . md5($js) . '.js';
        file_put_contents($tmp, $js);
        exec("node --check " . escapeshellarg($tmp) . " 2>&1", $out, $code);
        $this->assertSame(0, $code, 'node --check failed: ' . implode("\n", (array) $out));
        foreach (['inventory.stock', 'inventory.opname', 'inventory.transfers'] as $r) {
            $html2 = $this->get(route($r))->getContent();
            preg_match_all('/<script(?:[^>]*)>(.*?)<\/script>/s', $html2, $m2);
            $js2 = implode("\n", $m2[1] ?? []);
            $tmp2 = sys_get_temp_dir() . '/modal-js2-' . $r . '.js';
            file_put_contents($tmp2, $js2);
            exec("node --check " . escapeshellarg($tmp2) . " 2>&1", $out2, $code2);
            $this->assertSame(0, $code2, "$r js invalid: " . implode("\n", (array) $out2));
        }
    }

    public function test_guest_redirects_on_protected_pages(): void
    {
        foreach (['dashboard','system.users','master-data.products','reports.aging'] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
    }
}
