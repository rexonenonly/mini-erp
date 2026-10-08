<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    protected $fillable = ['opname_id', 'product_id', 'system_qty', 'physical_qty', 'unit_cost'];

    protected $casts = [
        'system_qty' => 'decimal:3',
        'physical_qty' => 'decimal:3',
        'difference' => 'decimal:3',
        'unit_cost' => 'decimal:2',
    ];

    public function opname()
    {
        return $this->belongsTo(StockOpname::class, 'opname_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
