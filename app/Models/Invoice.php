<?php

namespace App\Models;

use App\Domain\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'number', 'invoice_date', 'due_date', 'delivery_id', 'sales_order_id', 'customer_id',
        'total_amount', 'paid_amount', 'status', 'notes', 'created_by',
        'posted_at', 'posted_by', 'reversed_by', 'reversed_at',
    ];

    protected $casts = [
        'invoice_date'  => 'date',
        'due_date'      => 'date',
        'total_amount'  => 'decimal:2',
        'paid_amount'   => 'decimal:2',
        'posted_at'     => 'datetime',
        'reversed_at'   => 'datetime',
    ];

    public function delivery() { return $this->belongsTo(Delivery::class); }
    public function customer() { return $this->belongsTo(Partner::class, 'customer_id'); }
    public function payments() { return $this->hasMany(CustomerPayment::class, 'invoice_id'); }
    public function lines()    { return $this->hasMany(InvoiceLine::class); }
}