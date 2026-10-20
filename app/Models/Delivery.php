<?php

namespace App\Models;

use App\Domain\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'number', 'delivery_date', 'sales_order_id', 'customer_id',
        'warehouse_id', 'total_value', 'total_cost', 'status', 'notes', 'created_by',
        'posted_at', 'posted_by', 'reversed_by', 'reversed_at',
    ];

    protected $casts = [
        'delivery_date' => 'date',
        'total_value'   => 'decimal:2',
        'total_cost'    => 'decimal:2',
        'posted_at'     => 'datetime',
        'reversed_at'   => 'datetime',
    ];

    public function salesOrder() { return $this->belongsTo(SalesOrder::class, 'sales_order_id'); }
    public function customer()   { return $this->belongsTo(Partner::class, 'customer_id'); }
    public function warehouse()  { return $this->belongsTo(Warehouse::class); }
    public function creator()    { return $this->belongsTo(User::class, 'created_by'); }
    public function lines()      { return $this->hasMany(DeliveryLine::class); }
}