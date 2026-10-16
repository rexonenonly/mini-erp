<?php

namespace App\Domain\Core\Contracts;

interface PeriodGuard
{
    /**
     * Assert that the given date falls within an open accounting period.
     * 
     * @throws \RuntimeException if period is closed
     */
    public function assertOpen(\DateTimeInterface $date): void;
}
