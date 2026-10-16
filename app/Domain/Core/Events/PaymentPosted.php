<?php
namespace App\Domain\Core\Events;
class PaymentPosted { public function __construct(public readonly int $paymentId, public readonly string $direction, public readonly int $userId) {} }
