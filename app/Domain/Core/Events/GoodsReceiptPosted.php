<?php
namespace App\Domain\Core\Events;
class GoodsReceiptPosted { public function __construct(public readonly int $receiptId, public readonly int $userId) {} }
