<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorBillLine extends Model
{
    protected $fillable = ['vendor_bill_id', 'product_id', 'description', 'amount'];
    protected $casts = ['amount' => 'decimal:2'];

    public function vendorBill() { return $this->belongsTo(VendorBill::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
