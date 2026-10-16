<?php
namespace App\Domain\Core\Events;
class DeliveryPosted { public function __construct(public readonly int $deliveryId, public readonly int $userId) {} }
