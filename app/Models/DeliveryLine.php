<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryLine extends Model
{
    protected $fillable = [
        'delivery_id', 'sales_order_item_id', 'product_id',
        'qty', 'unit', 'unit_cost', 'line_cost', 'subtotal', 'notes',
    ];
    protected $casts = [
        'qty'      => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'line_cost' => 'decimal:2',
        'subtotal'  => 'decimal:2',
    ];

    public function delivery() { return $this->belongsTo(Delivery::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
