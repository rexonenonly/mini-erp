<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBalance extends Model
{
    protected $fillable = [
        'product_id', 'warehouse_id',
        'on_hand', 'reserved', 'unit_cost',   // legacy columns kept for compatibility
        'qty_reserved', 'total_value', 'avg_cost',
    ];

    protected $casts = [
        'on_hand'      => 'decimal:4',
        'reserved'     => 'decimal:4',
        'unit_cost'    => 'decimal:4',
        'qty_reserved' => 'decimal:4',
        'total_value'  => 'decimal:2',
        'avg_cost'     => 'decimal:4',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /** Available = on_hand - qty_reserved (exact bcmath) */
    public function getAvailableAttribute(): string
    {
        return bcsub((string) $this->on_hand, (string) $this->qty_reserved, 4);
    }

    public function getValueAttribute()
    {
        return round((float) $this->on_hand * (float) $this->unit_cost, 2);
    }

    public function getStatusAttribute()
    {
        $min = (float) ($this->product->min_stock ?? 0);
        $onHand = (float) $this->on_hand;

        if ($onHand <= 0) return 'habis';
        if ($min > 0 && $onHand <= $min * 0.5) return 'kritis';
        if ($min > 0 && $onHand <= $min) return 'menipis';

        return 'tersedia';
    }
}
