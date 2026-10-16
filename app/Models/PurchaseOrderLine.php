<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderLine extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_order_id', 'product_id', 'qty_ordered', 'qty_received',
        'unit', 'unit_price', 'subtotal', 'notes',
    ];
    protected $casts = [
        'qty_ordered'  => 'decimal:4',
        'qty_received' => 'decimal:4',
        'unit_price'   => 'decimal:2',
        'subtotal'     => 'decimal:2',
    ];

    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
