<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;         // only created_at
    protected $guarded = [];            // allow mass-assign (internal only, never from user input)

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    // Convenience factory for business events (confirmed, posted, reversed, etc.)
    public static function record(
        string $event,
        Model $model,
        array $oldValues = [],
        array $newValues = [],
        ?int $userId = null,
    ): void {
        static::create([
            'user_id'        => $userId ?? auth()->id(),
            'event'          => $event,
            'auditable_type' => $model::class,
            'auditable_id'   => $model->getKey(),
            'old_values'     => $oldValues ?: null,
            'new_values'     => $newValues ?: null,
            'ip_address'     => request()?->ip(),
            'user_agent'     => request()?->userAgent(),
            'created_at'     => now(),
        ]);
    }
}
