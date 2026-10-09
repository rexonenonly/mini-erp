<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsReceipt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number', 'receipt_date', 'purchase_order_id', 'supplier_id',
        'warehouse_id', 'total_value', 'status', 'notes', 'created_by', 'posted_at',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'total_value' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}