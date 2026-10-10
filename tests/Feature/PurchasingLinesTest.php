<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderLine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchasingLinesTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_purchase_order_with_lines(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('purchase-orders.create');
        
        \DB::table('warehouses')->insert([
            'id' => 1,
            'name' => 'Gudang Utama',
            'code' => 'GDG-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $partner = Partner::factory()->create(['type' => 'supplier']);
        $product = Product::factory()->create(['purchase_price' => 15000]);

        $response = $this->actingAs($user)->postJson('/purchasing/purchase-orders', [
            'supplier_id' => $partner->id,
            'warehouse_id' => 1,
            'order_date' => now()->toDateString(),
            'expected_date' => now()->addWeek()->toDateString(),
            'status' => 'draft',
            'total_amount' => 225000,
            'lines' => [
                ['product_id' => $product->id, 'qty' => 10, 'unit' => 'pcs', 'unit_price' => 15000],
                ['product_id' => $product->id, 'qty' => 5, 'unit' => 'pcs', 'unit_price' => 15000],
            ],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('purchase_orders', 1);
        $this->assertDatabaseCount('purchase_order_lines', 2);
        $this->assertDatabaseHas('purchase_order_lines', ['qty' => 10, 'unit_price' => 15000]);
        $this->assertDatabaseHas('purchase_order_lines', ['qty' => 5, 'unit_price' => 15000]);
    }
}
