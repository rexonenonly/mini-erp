<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBalance extends Model
{
    protected $fillable = ['product_id', 'warehouse_id', 'on_hand', 'reserved', 'unit_cost'];

    protected $casts = [
        'on_hand' => 'decimal:3',
        'reserved' => 'decimal:3',
        'unit_cost' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function getAvailableAttribute()
    {
        return round((float) $this->on_hand - (float) $this->reserved, 3);
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
