<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOpname extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number', 'opname_date', 'warehouse_id', 'notes',
        'status', 'created_by', 'posted_at',
    ];

    protected $casts = [
        'opname_date' => 'date',
        'posted_at' => 'datetime',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(StockOpnameItem::class, 'opname_id');
    }
}
