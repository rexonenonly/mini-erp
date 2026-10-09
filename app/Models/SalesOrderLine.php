<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderLine extends Model
{
    protected $fillable = ['sales_order_id', 'product_id', 'qty', 'unit', 'unit_price', 'subtotal', 'notes'];
    protected $casts = ['qty' => 'decimal:3', 'unit_price' => 'decimal:2', 'subtotal' => 'decimal:2'];

    public function salesOrder() { return $this->belongsTo(SalesOrder::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
