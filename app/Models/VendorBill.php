<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorBill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number', 'supplier_bill_number', 'bill_date', 'due_date',
        'receipt_id', 'purchase_order_id', 'supplier_id',
        'total_amount', 'paid_amount', 'status', 'notes',
        'created_by', 'posted_at', 'posted_by', 'reversed_by', 'reversed_at',
    ];

    protected $casts = [
        'bill_date'    => 'date',
        'due_date'     => 'date',
        'posted_at'    => 'datetime',
        'reversed_at'  => 'datetime',
        'total_amount' => 'decimal:2',
        'paid_amount'  => 'decimal:2',
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

    public function lines()
    {
        return $this->hasMany(VendorBillLine::class);
    }
}