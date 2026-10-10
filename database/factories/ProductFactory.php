<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->lexify('SKU-????'),
            'name' => $this->faker->words(3, true),
            'unit' => 'pcs',
            'purchase_price' => 10000,
            'sale_price' => 15000,
            'min_stock' => 5,
            'is_active' => true,
        ];
    }
}