<?php

return [
    // Event → Account mapping (system_key basis, not code)
    'mappings' => [
        'GoodsReceiptPosted' => [
            'debit' => 'inventory',
            'credit' => 'grir',
        ],
        'VendorBillPosted' => [
            'debit' => 'grir',
            'credit' => 'payable',
        ],
        'PaymentPosted.out' => [ // payment to supplier
            'debit' => 'payable',
            'credit' => 'account_id', // dynamic: cash or bank selected
        ],
        'DeliveryPosted' => [
            'debit' => 'cogs',
            'credit' => 'inventory',
        ],
        'InvoicePosted' => [
            'debit' => 'receivable',
            'credit' => 'sales',
        ],
        'PaymentPosted.in' => [ // payment from customer
            'debit' => 'account_id', // dynamic
            'credit' => 'receivable',
        ],
        'StockOpnamePosted.positive' => [ // surplus
            'debit' => 'inventory',
            'credit' => 'inventory_adjustment',
        ],
        'StockOpnamePosted.negative' => [ // deficit
            'debit' => 'inventory_adjustment',
            'credit' => 'inventory',
        ],
        // StockTransferPosted: no journal (inventory total unchanged)
    ],
];
