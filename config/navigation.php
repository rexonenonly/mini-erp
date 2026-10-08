<?php

return [
    'pages' => [
        ['group' => null, 'label' => 'Dashboard', 'title' => 'Dashboard', 'subtitle' => 'Ringkasan operasional bisnis', 'route' => 'dashboard', 'action' => null, 'icon' => 'dashboard'],

        ['group' => 'Master Data', 'label' => 'Produk', 'title' => 'Produk', 'subtitle' => 'Kelola daftar produk dan harga', 'route' => 'master-data.products', 'action' => ['label' => 'Produk Baru', 'route' => null], 'icon' => 'inventory_2'],
        ['group' => 'Master Data', 'label' => 'Gudang', 'title' => 'Gudang', 'subtitle' => 'Kelola lokasi penyimpanan barang', 'route' => 'master-data.warehouses', 'action' => ['label' => 'Gudang Baru', 'route' => null], 'icon' => 'warehouse'],
        ['group' => 'Master Data', 'label' => 'Mitra', 'title' => 'Mitra', 'subtitle' => 'Kelola customer dan supplier', 'route' => 'master-data.partners', 'action' => ['label' => 'Mitra Baru', 'route' => null], 'icon' => 'handshake'],
        ['group' => 'Master Data', 'label' => 'Akun', 'title' => 'Akun', 'subtitle' => 'Kelola akun akuntansi (Chart of Accounts)', 'route' => 'master-data.accounts', 'action' => ['label' => 'Akun Baru', 'route' => null], 'icon' => 'account_tree'],

        ['group' => 'Inventory', 'label' => 'Stok', 'title' => 'Stok', 'subtitle' => 'Pantau stok, reservasi, dan nilai persediaan per gudang', 'route' => 'inventory.stock', 'action' => null, 'icon' => 'inventory'],
        ['group' => 'Inventory', 'label' => 'Opname', 'title' => 'Opname Stok', 'subtitle' => 'Catat hasil hitung fisik dan selisih stok', 'route' => 'inventory.opname', 'action' => ['label' => 'Opname Baru', 'route' => null], 'icon' => 'fact_check'],
        ['group' => 'Inventory', 'label' => 'Transfer', 'title' => 'Transfer Stok', 'subtitle' => 'Pindahkan stok antar gudang', 'route' => 'inventory.transfers', 'action' => ['label' => 'Transfer Baru', 'route' => null], 'icon' => 'swap_horiz'],

        ['group' => 'Purchasing', 'label' => 'Purchase Order', 'title' => 'Purchase Order', 'subtitle' => 'Pesan barang ke supplier', 'route' => 'purchasing.orders', 'action' => ['label' => 'Purchase Order Baru', 'route' => null], 'icon' => 'shopping_cart'],
        ['group' => 'Purchasing', 'label' => 'Penerimaan', 'title' => 'Penerimaan Barang', 'subtitle' => 'Catat barang yang diterima dari supplier', 'route' => 'purchasing.receipts', 'action' => ['label' => 'Penerimaan Baru', 'route' => null], 'icon' => 'move_to_inbox'],
        ['group' => 'Purchasing', 'label' => 'Tagihan', 'title' => 'Tagihan', 'subtitle' => 'Kelola tagihan dari supplier', 'route' => 'purchasing.bills', 'action' => ['label' => 'Tagihan Baru', 'route' => null], 'icon' => 'receipt_long'],
        ['group' => 'Purchasing', 'label' => 'Pembayaran', 'title' => 'Pembayaran ke Supplier', 'subtitle' => 'Catat pembayaran ke supplier', 'route' => 'purchasing.payments', 'action' => ['label' => 'Pembayaran Baru', 'route' => null], 'icon' => 'payments'],

        ['group' => 'Sales', 'label' => 'Sales Order', 'title' => 'Sales Order', 'subtitle' => 'Kelola pesanan dari customer', 'route' => 'sales.orders', 'action' => ['label' => 'Sales Order Baru', 'route' => null], 'icon' => 'point_of_sale'],
        ['group' => 'Sales', 'label' => 'Pengiriman', 'title' => 'Pengiriman', 'subtitle' => 'Catat pengiriman barang ke customer', 'route' => 'sales.deliveries', 'action' => ['label' => 'Pengiriman Baru', 'route' => null], 'icon' => 'local_shipping'],
        ['group' => 'Sales', 'label' => 'Invoice', 'title' => 'Invoice', 'subtitle' => 'Kelola faktur penjualan', 'route' => 'sales.invoices', 'action' => ['label' => 'Invoice Baru', 'route' => null], 'icon' => 'description'],
        ['group' => 'Sales', 'label' => 'Pembayaran', 'title' => 'Pembayaran dari Customer', 'subtitle' => 'Catat pembayaran dari customer', 'route' => 'sales.payments', 'action' => ['label' => 'Pembayaran Baru', 'route' => null], 'icon' => 'payments'],

        ['group' => 'Accounting', 'label' => 'Jurnal Umum', 'title' => 'Jurnal Umum', 'subtitle' => 'Tinjau dan buat jurnal', 'route' => 'accounting.journals', 'action' => ['label' => 'Jurnal Manual Baru', 'route' => null], 'icon' => 'menu_book'],
        ['group' => 'Accounting', 'label' => 'Buku Besar', 'title' => 'Buku Besar', 'subtitle' => 'Lihat mutasi dan saldo per akun', 'route' => 'accounting.ledger', 'action' => null, 'icon' => 'account_balance'],
        ['group' => 'Accounting', 'label' => 'Periode', 'title' => 'Periode Akuntansi', 'subtitle' => 'Kelola periode akuntansi', 'route' => 'accounting.periods', 'action' => ['label' => 'Tutup Periode', 'route' => null, 'icon' => 'lock'], 'icon' => 'calendar_month'],

        ['group' => 'Laporan', 'label' => 'Neraca Saldo', 'title' => 'Neraca Saldo', 'subtitle' => 'Saldo debit dan kredit semua akun', 'route' => 'reports.trial-balance', 'action' => null, 'icon' => 'balance'],
        ['group' => 'Laporan', 'label' => 'Laba Rugi', 'title' => 'Laba Rugi', 'subtitle' => 'Pendapatan, HPP, dan beban per periode', 'route' => 'reports.income-statement', 'action' => null, 'icon' => 'bar_chart'],
        ['group' => 'Laporan', 'label' => 'Umur Piutang & Hutang', 'title' => 'Umur Piutang & Hutang', 'subtitle' => 'Umur piutang dan hutang', 'route' => 'reports.aging', 'action' => null, 'icon' => 'schedule'],
        ['group' => 'Laporan', 'label' => 'Nilai Persediaan', 'title' => 'Nilai Persediaan', 'subtitle' => 'Nilai persediaan per gudang dan produk', 'route' => 'reports.inventory-valuation', 'action' => null, 'icon' => 'analytics'],
    ],
    'system' => [
        ['label' => 'Pengguna & Role', 'route' => 'users.index', 'icon' => 'group'],
        ['label' => 'Audit Log', 'route' => 'audit.index', 'icon' => 'history'],
        ['label' => 'Kesehatan Sistem', 'route' => 'health.index', 'icon' => 'health_and_safety'],
    ],
];
