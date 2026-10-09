<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use SoftDeletes;

    protected $fillable = ['number', 'order_date', 'customer_id', 'warehouse_id', 'total_amount', 'status', 'notes', 'created_by', 'confirmed_at'];
    protected $casts = ['order_date' => 'date', 'total_amount' => 'decimal:2', 'confirmed_at' => 'datetime'];

    public function customer()  { return $this->belongsTo(Partner::class, 'customer_id'); }
    public function warehouse() { return $this->belongsTo(Warehouse::class); }
    public function creator()   { return $this->belongsTo(User::class, 'created_by'); }
    public function lines()     { return $this->hasMany(SalesOrderLine::class); }
}