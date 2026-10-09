<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['number', 'invoice_date', 'due_date', 'delivery_id', 'customer_id', 'total_amount', 'paid_amount', 'status', 'notes'];
    protected $casts = ['invoice_date' => 'date', 'due_date' => 'date', 'total_amount' => 'decimal:2', 'paid_amount' => 'decimal:2'];

    public function delivery() { return $this->belongsTo(Delivery::class); }
    public function customer() { return $this->belongsTo(Partner::class, 'customer_id'); }
    public function payments() { return $this->hasMany(CustomerPayment::class, 'invoice_id'); }
    public function lines()    { return $this->hasMany(InvoiceLine::class); }
}