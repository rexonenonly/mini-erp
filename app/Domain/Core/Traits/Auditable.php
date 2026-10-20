<?php

namespace App\Domain\Core\Traits;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            AuditLog::record('created', $model, [], $model->getAttributes());
        });

        static::updated(function ($model) {
            $changed = $model->getChanges();
            unset($changed['updated_at']);
            if (empty($changed)) return;

            AuditLog::record(
                'updated', $model,
                array_intersect_key($model->getOriginal(), $changed),
                $changed,
            );
        });

        static::deleted(function ($model) {
            AuditLog::record('deleted', $model, $model->getAttributes());
        });
    }

    // Call from Action classes for business events (confirmed, posted, reversed, cancelled)
    public function auditEvent(string $event, array $context = []): void
    {
        AuditLog::record($event, $this, [], $context);
    }
}
