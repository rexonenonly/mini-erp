<?php

return [
    // Status DB value → [label, color]
    'order' => [ // PO, SO
        'draft' => ['Draft', 'gray'],
        'confirmed' => ['Dikonfirmasi', 'green'],
        'partial' => ['Parsial', 'yellow'],
        'done' => ['Selesai', 'blue'],
        'cancelled' => ['Dibatalkan', 'red'],
    ],
    'document' => [ // GR, Delivery, Opname, Transfer
        'draft' => ['Draft', 'gray'],
        'posted' => ['Diposting', 'green'],
        'reversed' => ['Dibalik', 'red'],
    ],
    'settlement' => [ // Bill, Invoice
        'draft' => ['Draft', 'gray'],
        'open' => ['Terbuka', 'blue'],
        'partially_paid' => ['Dibayar Sebagian', 'yellow'],
        'paid' => ['Lunas', 'green'],
        'reversed' => ['Dibalik', 'red'],
    ],
    'posting' => [ // Payment, Journal
        'posted' => ['Diposting', 'green'],
        'reversed' => ['Dibalik', 'red'],
    ],
    'period' => [ // Fiscal Period
        'open' => ['Terbuka', 'green'],
        'closed' => ['Ditutup', 'red'],
    ],
    'stock_level' => [ // computed, not stored
        'tersedia' => ['Tersedia', 'green'],
        'menipis' => ['Menipis', 'yellow'],
        'kritis' => ['Kritis', 'orange'],
        'habis' => ['Habis', 'red'],
    ],
];
