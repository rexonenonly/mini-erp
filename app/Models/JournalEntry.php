<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'number', 'entry_date', 'fiscal_period_id', 'description',
        'source_type', 'source_id', 'kind', 'reverses_entry_id',
        'status', 'total', 'created_by', 'created_at',
    ];

    protected $casts = [
        'entry_date' => 'date',
        'total'      => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function lines()
    {
        return $this->hasMany(JournalLine::class);
    }

    public function fiscalPeriod()
    {
        return $this->belongsTo(FiscalPeriod::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reversedEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'reverses_entry_id');
    }
}
