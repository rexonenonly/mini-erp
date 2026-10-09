<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $fillable = ['invoice_id', 'product_id', 'description', 'qty', 'unit_price', 'subtotal'];
    protected $casts = ['qty' => 'decimal:3', 'unit_price' => 'decimal:2', 'subtotal' => 'decimal:2'];

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
