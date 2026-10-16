<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderLine extends Model
{
    protected $fillable = [
        'sales_order_id', 'product_id', 'qty_ordered', 'qty_reserved', 'qty_delivered',
        'unit', 'unit_price', 'subtotal', 'notes',
    ];
    protected $casts = [
        'qty_ordered'   => 'decimal:4',
        'qty_reserved'  => 'decimal:4',
        'qty_delivered' => 'decimal:4',
        'unit_price'    => 'decimal:2',
        'subtotal'      => 'decimal:2',
    ];

    public function salesOrder() { return $this->belongsTo(SalesOrder::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
