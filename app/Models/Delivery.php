<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    protected $fillable = ['number', 'delivery_date', 'sales_order_id', 'customer_id', 'warehouse_id', 'total_value', 'status', 'notes', 'created_by', 'posted_at'];
    protected $casts = ['delivery_date' => 'date', 'total_value' => 'decimal:2', 'posted_at' => 'datetime'];

    public function salesOrder() { return $this->belongsTo(SalesOrder::class, 'sales_order_id'); }
    public function customer()   { return $this->belongsTo(Partner::class, 'customer_id'); }
    public function warehouse()  { return $this->belongsTo(Warehouse::class); }
    public function creator()    { return $this->belongsTo(User::class, 'created_by'); }
}