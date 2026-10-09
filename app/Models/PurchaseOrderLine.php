<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderLine extends Model
{
    protected $fillable = ['purchase_order_id', 'product_id', 'qty', 'unit', 'unit_price', 'subtotal', 'notes'];
    protected $casts = ['qty' => 'decimal:3', 'unit_price' => 'decimal:2', 'subtotal' => 'decimal:2'];

    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
