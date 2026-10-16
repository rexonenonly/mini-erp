<?php
namespace App\Domain\Core\Events;
class VendorBillPosted { public function __construct(public readonly int $billId, public readonly int $userId) {} }
