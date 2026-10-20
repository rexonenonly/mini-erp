<?php

namespace App\Models;

use App\Domain\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPayment extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'number', 'payment_date', 'bill_id', 'supplier_id', 'account_id',
        'amount', 'method', 'status', 'notes', 'reference', 'created_by',
        'posted_at', 'posted_by', 'reversed_by', 'reversed_at',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
        'posted_at'    => 'datetime',
        'reversed_at'  => 'datetime',
    ];

    public function bill()
    {
        return $this->belongsTo(VendorBill::class, 'bill_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}