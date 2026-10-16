<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalPeriod extends Model
{
    protected $fillable = ['year', 'month', 'start_date', 'end_date', 'status', 'closed_by', 'closed_at'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'closed_at'  => 'datetime',
    ];

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /** Find or create fiscal period for a given date. */
    public static function forDate(\DateTimeInterface $date): static
    {
        return static::firstOrCreate(
            ['year' => (int) $date->format('Y'), 'month' => (int) $date->format('n')],
            [
                'start_date' => $date->format('Y-m-01'),
                'end_date'   => date('Y-m-t', mktime(0, 0, 0, $date->format('n'), 1, $date->format('Y'))),
                'status'     => 'open',
            ]
        );
    }
}
