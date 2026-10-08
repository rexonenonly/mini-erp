<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'unit', 'purchase_price', 'sale_price', 'min_stock', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'purchase_price' => 'decimal:2', 'sale_price' => 'decimal:2'];
}
