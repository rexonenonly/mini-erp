<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    public $timestamps = false; // only created_at, no updated_at

    protected $fillable = [
        'product_id', 'warehouse_id', 'type', 'is_reversal', 'reverses_id',
        'qty_change', 'unit_cost', 'value_change',
        'qty_after', 'value_after', 'avg_cost_after',
        'source_type', 'source_id', 'occurred_at', 'created_by', 'created_at',
    ];

    protected $casts = [
        'is_reversal'    => 'boolean',
        'qty_change'     => 'decimal:4',
        'unit_cost'      => 'decimal:4',
        'value_change'   => 'decimal:2',
        'qty_after'      => 'decimal:4',
        'value_after'    => 'decimal:2',
        'avg_cost_after' => 'decimal:4',
        'occurred_at'    => 'datetime',
        'created_at'     => 'datetime',
    ];

    // Explicitly set created_at on insert; no updated_at column
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
