<?php

namespace App\Domain\Core\Traits;

trait Auditable
{
    // ponytail: append-only audit log via observer, implement in Phase 6
    
    public static function bootAuditable(): void
    {
        // static::created(fn($m) => AuditLog::record('created', $m));
        // static::updated(fn($m) => AuditLog::record('updated', $m));
        // static::deleted(fn($m) => AuditLog::record('deleted', $m));
    }
}
