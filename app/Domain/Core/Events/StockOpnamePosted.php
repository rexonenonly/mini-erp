<?php
namespace App\Domain\Core\Events;
class StockOpnamePosted { public function __construct(public readonly int $opnameId, public readonly int $userId) {} }
