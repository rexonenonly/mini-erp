<?php

return [
    'groups' => [
        'Master Data' => [
            'products' => ['label' => 'Produk', 'actions' => ['view', 'create', 'update']],
            'warehouses' => ['label' => 'Gudang', 'actions' => ['view', 'create', 'update']],
            'partners' => ['label' => 'Mitra', 'actions' => ['view', 'create', 'update']],
            'accounts' => ['label' => 'Akun', 'actions' => ['view', 'create', 'update']],
        ],
        'Inventory' => [
            'stock' => ['label' => 'Stok', 'actions' => ['view', 'create', 'update']],
            'stock-opnames' => ['label' => 'Opname Stok', 'actions' => ['view', 'create', 'update', 'post', 'reverse']],
            'stock-transfers' => ['label' => 'Transfer Stok', 'actions' => ['view', 'create', 'update', 'post', 'reverse']],
        ],
        'Purchasing' => [
            'purchase-orders' => ['label' => 'Purchase Order', 'actions' => ['view', 'create', 'update', 'confirm', 'cancel']],
            'goods-receipts' => ['label' => 'Penerimaan Barang', 'actions' => ['view', 'create', 'update', 'post', 'reverse']],
            'vendor-bills' => ['label' => 'Tagihan', 'actions' => ['view', 'create', 'update', 'post', 'reverse']],
            'supplier-payments' => ['label' => 'Pembayaran ke Supplier', 'actions' => ['view', 'create', 'reverse']],
        ],
        'Sales' => [
            'sales-orders' => ['label' => 'Sales Order', 'actions' => ['view', 'create', 'update', 'confirm', 'cancel']],
            'deliveries' => ['label' => 'Pengiriman', 'actions' => ['view', 'create', 'update', 'post', 'reverse']],
            'invoices' => ['label' => 'Invoice', 'actions' => ['view', 'create', 'update', 'post', 'reverse']],
            'customer-payments' => ['label' => 'Pembayaran dari Customer', 'actions' => ['view', 'create', 'reverse']],
        ],
        'Accounting' => [
            'journals' => ['label' => 'Jurnal Umum', 'actions' => ['view', 'create', 'reverse']],
            'ledger' => ['label' => 'Buku Besar', 'actions' => ['view']],
            'periods' => ['label' => 'Periode', 'actions' => ['view', 'close']],
        ],
        'Laporan' => [
            'trial-balance' => ['label' => 'Neraca Saldo', 'actions' => ['view']],
            'income-statement' => ['label' => 'Laba Rugi', 'actions' => ['view']],
            'aging-receivable' => ['label' => 'Umur Piutang', 'actions' => ['view']],
            'aging-payable' => ['label' => 'Umur Hutang', 'actions' => ['view']],
            'inventory-valuation' => ['label' => 'Nilai Persediaan', 'actions' => ['view']],
        ],
        'Sistem' => [
            'users' => ['label' => 'Pengguna', 'actions' => ['view', 'create', 'update']],
            'roles' => ['label' => 'Role & Izin', 'actions' => ['view', 'create', 'update']],
            'audit-logs' => ['label' => 'Audit Log', 'actions' => ['view']],
            'system-health' => ['label' => 'Kesehatan Sistem', 'actions' => ['view']],
        ],
    ],

    'action_labels' => [
        'view' => 'Lihat',
        'create' => 'Buat',
        'update' => 'Ubah',
        'confirm' => 'Konfirmasi',
        'cancel' => 'Batalkan',
        'post' => 'Posting',
        'reverse' => 'Balik',
        'close' => 'Tutup',
    ],

    // flat list helper — derived, but keep declared for reference
    // permission name = "<resource>.<action>"
];
