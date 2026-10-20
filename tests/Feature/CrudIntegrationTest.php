<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([\Database\Seeders\RolePermissionSeeder::class]);
    $this->seed([\Database\Seeders\DatabaseSeeder::class]);
});

test('Product CRUD: create, update, delete via HTTP', function () {
    $user = User::where('email', 'owner@minierp.test')->first();
    $this->actingAs($user);

    // CREATE
    $response = $this->post('/master-data/products', [
        'sku' => 'TEST-001',
        'name' => 'Produk Test',
        'unit' => 'pcs',
        'purchase_price' => '50000',
        'sale_price' => '75000',
        'min_stock' => '5',
        'is_active' => '1',
    ]);
    $response->assertOk();
    $product = Product::where('sku', 'TEST-001')->first();
    expect($product)->not->toBeNull()
        ->and($product->name)->toBe('Produk Test')
        ->and($product->purchase_price)->toBe('50000.00');

    // UPDATE
    $response = $this->put("/master-data/products/{$product->id}", [
        'sku' => 'TEST-001',
        'name' => 'Produk Updated',
        'unit' => 'pcs',
        'purchase_price' => '60000',
        'sale_price' => '80000',
        'min_stock' => '10',
        'is_active' => '1',
    ]);
    $response->assertOk();
    $product->refresh();
    expect($product->name)->toBe('Produk Updated')
        ->and($product->purchase_price)->toBe('60000.00')
        ->and((float)$product->min_stock)->toBe(10.0);

    // DELETE
    $response = $this->delete("/master-data/products/{$product->id}");
    $response->assertOk();
    expect(Product::find($product->id))->toBeNull();
});

test('Warehouse CRUD: create, update, delete via HTTP', function () {
    $user = User::where('email', 'owner@minierp.test')->first();
    $this->actingAs($user);

    $response = $this->post('/master-data/warehouses', [
        'code' => 'WH-TEST',
        'name' => 'Gudang Test',
        'address' => 'Jakarta',
        'is_active' => '1',
    ]);
    $response->assertOk();
    $wh = Warehouse::where('code', 'WH-TEST')->first();
    expect($wh)->not->toBeNull()
        ->and($wh->name)->toBe('Gudang Test');

    $response = $this->put("/master-data/warehouses/{$wh->id}", [
        'code' => 'WH-TEST',
        'name' => 'Gudang Updated',
        'address' => 'Bandung',
        'is_active' => '1',
    ]);
    $response->assertOk();
    $wh->refresh();
    expect($wh->name)->toBe('Gudang Updated')
        ->and($wh->address)->toBe('Bandung');

    $response = $this->delete("/master-data/warehouses/{$wh->id}");
    $response->assertOk();
    expect(Warehouse::find($wh->id))->toBeNull();
});
