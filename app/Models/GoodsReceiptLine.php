<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptLine extends Model
{
    protected $fillable = [
        'goods_receipt_id', 'purchase_order_item_id', 'product_id',
        'qty_received', 'unit', 'unit_cost', 'subtotal', 'notes',
    ];
    protected $casts = [
        'qty_received' => 'decimal:4',
        'unit_cost'    => 'decimal:2',
        'subtotal'     => 'decimal:2',
    ];

    public function goodsReceipt() { return $this->belongsTo(GoodsReceipt::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
