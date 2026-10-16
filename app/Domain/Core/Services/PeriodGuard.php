<?php

namespace App\Domain\Core\Services;

use App\Domain\Core\Contracts\PeriodGuard as PeriodGuardContract;
use App\Models\FiscalPeriod;
use RuntimeException;

/**
 * Checks if a fiscal period is open before posting.
 * Auto-creates the period if it doesn't exist (first posting of the month).
 */
class PeriodGuard implements PeriodGuardContract
{
    public function assertOpen(\DateTimeInterface $date): void
    {
        $period = FiscalPeriod::forDate($date);

        if ($period->isClosed()) {
            throw new RuntimeException(
                sprintf('Periode fiskal %d-%02d sudah ditutup', $period->year, $period->month)
            );
        }
    }
}
