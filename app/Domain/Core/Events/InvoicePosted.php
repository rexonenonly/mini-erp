<?php
namespace App\Domain\Core\Events;
class InvoicePosted { public function __construct(public readonly int $invoiceId, public readonly int $userId) {} }
