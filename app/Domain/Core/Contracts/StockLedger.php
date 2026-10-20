<?php

namespace App\Domain\Core\Contracts;

use App\Domain\Core\DTO\StockIn;
use App\Domain\Core\DTO\StockOut;
use App\Domain\Core\DTO\StockAdjustment;

interface StockLedger
{
    /**
     * Record stock receipt (incoming goods).
     */
    public function receive(StockIn $dto): void;

    /**
     * Record stock delivery (outgoing goods).
     */
    public function deliver(StockOut $dto): void;

    /**
     * Record stock adjustment (opname, correction).
     */
    public function adjust(StockAdjustment $dto): void;
}
