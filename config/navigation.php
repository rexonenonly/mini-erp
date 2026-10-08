<?php

return [
    'pages' => [
        ['group' => null, 'label' => 'Dashboard', 'title' => 'Dashboard', 'subtitle' => 'Ringkasan operasional bisnis', 'route' => 'dashboard', 'permission' => null, 'action' => null, 'icon' => 'dashboard'],

        ['group' => 'Master Data', 'label' => 'Produk', 'title' => 'Produk', 'subtitle' => 'Kelola daftar produk dan harga', 'route' => 'master-data.products', 'permission' => 'products.view', 'action' => ['label' => 'Produk Baru', 'route' => null, 'permission' => 'products.create'], 'icon' => 'inventory_2'],
        ['group' => 'Master Data', 'label' => 'Gudang', 'title' => 'Gudang', 'subtitle' => 'Kelola lokasi penyimpanan barang', 'route' => 'master-data.warehouses', 'permission' => 'warehouses.view', 'action' => ['label' => 'Gudang Baru', 'route' => null, 'permission' => 'warehouses.create'], 'icon' => 'warehouse'],
        ['group' => 'Master Data', 'label' => 'Mitra', 'title' => 'Mitra', 'subtitle' => 'Kelola customer dan supplier', 'route' => 'master-data.partners', 'permission' => 'partners.view', 'action' => ['label' => 'Mitra Baru', 'route' => null, 'permission' => 'partners.create'], 'icon' => 'handshake'],
        ['group' => 'Master Data', 'label' => 'Akun', 'title' => 'Akun', 'subtitle' => 'Kelola akun akuntansi (Chart of Accounts)', 'route' => 'master-data.accounts', 'permission' => 'accounts.view', 'action' => ['label' => 'Akun Baru', 'route' => null, 'permission' => 'accounts.create'], 'icon' => 'account_tree'],

        ['group' => 'Inventory', 'label' => 'Stok', 'title' => 'Stok', 'subtitle' => 'Pantau stok, reservasi, dan nilai persediaan per gudang', 'route' => 'inventory.stock', 'permission' => 'stock.view', 'action' => null, 'icon' => 'inventory'],
        ['group' => 'Inventory', 'label' => 'Opname', 'title' => 'Opname Stok', 'subtitle' => 'Catat hasil hitung fisik dan selisih stok', 'route' => 'inventory.opname', 'permission' => 'stock-opnames.view', 'action' => ['label' => 'Opname Baru', 'route' => null, 'permission' => 'stock-opnames.create'], 'icon' => 'fact_check'],
        ['group' => 'Inventory', 'label' => 'Transfer', 'title' => 'Transfer Stok', 'subtitle' => 'Pindahkan stok antar gudang', 'route' => 'inventory.transfers', 'permission' => 'stock-transfers.view', 'action' => ['label' => 'Transfer Baru', 'route' => null, 'permission' => 'stock-transfers.create'], 'icon' => 'swap_horiz'],

        ['group' => 'Purchasing', 'label' => 'Purchase Order', 'title' => 'Purchase Order', 'subtitle' => 'Pesan barang ke supplier', 'route' => 'purchasing.orders', 'permission' => 'purchase-orders.view', 'action' => ['label' => 'Purchase Order Baru', 'route' => null, 'permission' => 'purchase-orders.create'], 'icon' => 'shopping_cart'],
        ['group' => 'Purchasing', 'label' => 'Penerimaan', 'title' => 'Penerimaan Barang', 'subtitle' => 'Catat barang yang diterima dari supplier', 'route' => 'purchasing.receipts', 'permission' => 'goods-receipts.view', 'action' => ['label' => 'Penerimaan Baru', 'route' => null, 'permission' => 'goods-receipts.create'], 'icon' => 'move_to_inbox'],
        ['group' => 'Purchasing', 'label' => 'Tagihan', 'title' => 'Tagihan', 'subtitle' => 'Kelola tagihan dari supplier', 'route' => 'purchasing.bills', 'permission' => 'vendor-bills.view', 'action' => ['label' => 'Tagihan Baru', 'route' => null, 'permission' => 'vendor-bills.create'], 'icon' => 'receipt_long'],
        ['group' => 'Purchasing', 'label' => 'Pembayaran', 'title' => 'Pembayaran ke Supplier', 'subtitle' => 'Catat pembayaran ke supplier', 'route' => 'purchasing.payments', 'permission' => 'supplier-payments.view', 'action' => ['label' => 'Pembayaran Baru', 'route' => null, 'permission' => 'supplier-payments.create'], 'icon' => 'payments'],

        ['group' => 'Sales', 'label' => 'Sales Order', 'title' => 'Sales Order', 'subtitle' => 'Kelola pesanan dari customer', 'route' => 'sales.orders', 'permission' => 'sales-orders.view', 'action' => ['label' => 'Sales Order Baru', 'route' => null, 'permission' => 'sales-orders.create'], 'icon' => 'point_of_sale'],
        ['group' => 'Sales', 'label' => 'Pengiriman', 'title' => 'Pengiriman', 'subtitle' => 'Catat pengiriman barang ke customer', 'route' => 'sales.deliveries', 'permission' => 'deliveries.view', 'action' => ['label' => 'Pengiriman Baru', 'route' => null, 'permission' => 'deliveries.create'], 'icon' => 'local_shipping'],
        ['group' => 'Sales', 'label' => 'Invoice', 'title' => 'Invoice', 'subtitle' => 'Kelola faktur penjualan', 'route' => 'sales.invoices', 'permission' => 'invoices.view', 'action' => ['label' => 'Invoice Baru', 'route' => null, 'permission' => 'invoices.create'], 'icon' => 'description'],
        ['group' => 'Sales', 'label' => 'Pembayaran', 'title' => 'Pembayaran dari Customer', 'subtitle' => 'Catat pembayaran dari customer', 'route' => 'sales.payments', 'permission' => 'customer-payments.view', 'action' => ['label' => 'Pembayaran Baru', 'route' => null, 'permission' => 'customer-payments.create'], 'icon' => 'payments'],

        ['group' => 'Accounting', 'label' => 'Jurnal Umum', 'title' => 'Jurnal Umum', 'subtitle' => 'Tinjau dan buat jurnal', 'route' => 'accounting.journals', 'permission' => 'journals.view', 'action' => ['label' => 'Jurnal Manual Baru', 'route' => null, 'permission' => 'journals.create'], 'icon' => 'menu_book'],
        ['group' => 'Accounting', 'label' => 'Buku Besar', 'title' => 'Buku Besar', 'subtitle' => 'Lihat mutasi dan saldo per akun', 'route' => 'accounting.ledger', 'permission' => 'ledger.view', 'action' => null, 'icon' => 'account_balance'],
        ['group' => 'Accounting', 'label' => 'Periode', 'title' => 'Periode Akuntansi', 'subtitle' => 'Kelola periode akuntansi', 'route' => 'accounting.periods', 'permission' => 'periods.view', 'action' => ['label' => 'Tutup Periode', 'route' => null, 'icon' => 'lock', 'permission' => 'periods.close'], 'icon' => 'calendar_month'],

        ['group' => 'Laporan', 'label' => 'Neraca Saldo', 'title' => 'Neraca Saldo', 'subtitle' => 'Saldo debit dan kredit semua akun', 'route' => 'reports.trial-balance', 'permission' => 'trial-balance.view', 'action' => null, 'icon' => 'balance'],
        ['group' => 'Laporan', 'label' => 'Laba Rugi', 'title' => 'Laba Rugi', 'subtitle' => 'Pendapatan, HPP, dan beban per periode', 'route' => 'reports.income-statement', 'permission' => 'income-statement.view', 'action' => null, 'icon' => 'bar_chart'],
        ['group' => 'Laporan', 'label' => 'Umur Piutang & Hutang', 'title' => 'Umur Piutang & Hutang', 'subtitle' => 'Umur piutang dan hutang', 'route' => 'reports.aging', 'permission' => 'reports.aging.view', 'action' => null, 'icon' => 'schedule'],
        ['group' => 'Laporan', 'label' => 'Nilai Persediaan', 'title' => 'Nilai Persediaan', 'subtitle' => 'Nilai persediaan per gudang dan produk', 'route' => 'reports.inventory-valuation', 'permission' => 'inventory-valuation.view', 'action' => null, 'icon' => 'analytics'],

        ['group' => 'Sistem', 'label' => 'Pengguna', 'title' => 'Pengguna', 'subtitle' => 'Kelola akun dan role pengguna', 'route' => 'system.users', 'permission' => 'users.view', 'action' => ['label' => 'Pengguna Baru', 'route' => 'system.users.create', 'permission' => 'users.create'], 'icon' => 'group'],
        ['group' => 'Sistem', 'label' => 'Role & Izin', 'title' => 'Role & Izin', 'subtitle' => 'Atur hak akses setiap role', 'route' => 'system.roles', 'permission' => 'roles.view', 'action' => ['label' => 'Role Baru', 'route' => 'system.roles.create', 'permission' => 'roles.create'], 'icon' => 'shield'],
    ],
    'system' => [
        ['label' => 'Pengguna', 'route' => 'system.users', 'permission' => 'users.view', 'icon' => 'group'],
        ['label' => 'Role & Izin', 'route' => 'system.roles', 'permission' => 'roles.view', 'icon' => 'shield'],
        ['label' => 'Audit Log', 'route' => 'audit.index', 'permission' => 'audit-logs.view', 'icon' => 'history'],
        ['label' => 'Kesehatan Sistem', 'route' => 'health.index', 'permission' => 'system-health.view', 'icon' => 'health_and_safety'],
    ],
];
