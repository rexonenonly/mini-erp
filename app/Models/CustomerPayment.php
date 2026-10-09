<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPayment extends Model
{
    use SoftDeletes;

    protected $fillable = ['number', 'payment_date', 'invoice_id', 'customer_id', 'amount', 'method', 'status', 'notes', 'created_by'];
    protected $casts = ['payment_date' => 'date', 'amount' => 'decimal:2'];

    public function invoice()  { return $this->belongsTo(Invoice::class); }
    public function customer() { return $this->belongsTo(Partner::class, 'customer_id'); }
    public function creator()  { return $this->belongsTo(User::class, 'created_by'); }
}