<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryLine extends Model
{
    protected $fillable = ['delivery_id', 'product_id', 'qty', 'unit', 'unit_cost', 'subtotal', 'notes'];
    protected $casts = ['qty' => 'decimal:3', 'unit_cost' => 'decimal:2', 'subtotal' => 'decimal:2'];

    public function delivery() { return $this->belongsTo(Delivery::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
