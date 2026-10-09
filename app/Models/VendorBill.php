<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorBill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number', 'bill_date', 'due_date', 'receipt_id', 'supplier_id',
        'total_amount', 'paid_amount', 'status', 'notes',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function receipt()
    {
        return $this->belongsTo(GoodsReceipt::class, 'receipt_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class, 'bill_id');
    }
}