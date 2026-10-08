# Mini ERP — Spesifikasi Halaman Final (docs/PAGES_SPEC.md)

Acuan struktur halaman, sidebar, URL, status, kolom, tombol, dan KPI **Mini ERP** (Laravel 10 + Tailwind + Blade). Mencerminkan kode di branch `refactor/pages-sidebar` setelah Phase 1–7. Satu halaman per item sidebar; tanpa tab navigation.

---

## Struktur Sidebar (config/navigation.php — sumber tunggal)

```
Dashboard
Master Data   : Produk · Gudang · Mitra · Akun
Inventory     : Stok · Opname · Transfer
Purchasing    : Purchase Order · Penerimaan · Tagihan · Pembayaran
Sales         : Sales Order · Pengiriman · Invoice · Pembayaran
Accounting    : Jurnal Umum · Buku Besar · Periode
Laporan       : Neraca Saldo · Laba Rugi · Umur Piutang & Hutang · Nilai Persediaan
──── divider ────
Sistem        : Pengguna & Role · Audit Log · Kesehatan Sistem (hanya jika Route::has)
```

- Sidebar `resources/views/components/layout/sidebar.blade.php` — accordion `<details name="sidebar">`: satu grup terbuka, grup halaman aktif terbuka saat load, item aktif di-highlight, ikon material-symbols per grup, tema dark navy, footer "Periode Akuntansi: Oktober 2026 (Open)".
- Top bar: breadcrumb `<Grup> / <Label item>` + menu user dropdown (Profile/Settings/Logout).
- `config/navigation.php` sumber tunggal: group, label, title, subtitle, route, action (tombol), icon, position.
- Header halaman `resources/views/components/ui/page-header.blade.php` resolve judul/subtitle/tombol via route name tanpa props (guard `Route::currentRouteName() ?? ''`).
- Exactly satu tombol primary per halaman (label di navigation.php; `action: null` = tanpa tombol; create pakai satu ikon plus).
- Tanpa permission system (tidak ada spatie/Gate) → sidebar tidak difilter.

## Rute & Tombol

| URL | Route Name | Judul | Subtitle | Tombol |
| --- | --- | --- | --- | --- |
| /dashboard | dashboard | Dashboard | Ringkasan operasional bisnis | – |
| /master-data/products | master-data.products | Produk | Kelola daftar produk dan harga | Produk Baru |
| /master-data/warehouses | master-data.warehouses | Gudang | Kelola lokasi penyimpanan barang | Gudang Baru |
| /master-data/partners | master-data.partners | Mitra | Kelola customer dan supplier | Mitra Baru |
| /master-data/accounts | master-data.accounts | Akun | Kelola akun akuntansi (Chart of Accounts) | Akun Baru |
| /inventory/stock | inventory.stock | Stok | Pantau stok, reservasi, dan nilai persediaan per gudang | – |
| /inventory/opname | inventory.opname | Opname Stok | Catat hasil hitung fisik dan selisih stok | Opname Baru |
| /inventory/transfers | inventory.transfers | Transfer Stok | Pindahkan stok antar gudang | Transfer Baru |
| /purchasing/orders | purchasing.orders | Purchase Order | Pesan barang ke supplier | Purchase Order Baru |
| /purchasing/receipts | purchasing.receipts | Penerimaan Barang | Catat barang yang diterima dari supplier | Penerimaan Baru |
| /purchasing/bills | purchasing.bills | Tagihan | Kelola tagihan dari supplier | Tagihan Baru |
| /purchasing/payments | purchasing.payments | Pembayaran ke Supplier | Catat pembayaran ke supplier | Pembayaran Baru |
| /sales/orders | sales.orders | Sales Order | Kelola pesanan dari customer | Sales Order Baru |
| /sales/deliveries | sales.deliveries | Pengiriman | Catat pengiriman barang ke customer | Pengiriman Baru |
| /sales/invoices | sales.invoices | Invoice | Kelola faktur penjualan | Invoice Baru |
| /sales/payments | sales.payments | Pembayaran dari Customer | Catat pembayaran dari customer | Pembayaran Baru |
| /accounting/journals | accounting.journals | Jurnal Umum | Tinjau dan buat jurnal | Jurnal Manual Baru |
| /accounting/ledger | accounting.ledger | Buku Besar | Lihat mutasi dan saldo per akun | – |
| /accounting/periods | accounting.periods | Periode Akuntansi | Kelola periode akuntansi | Tutup Periode (ikon lock) |
| /reports/trial-balance | reports.trial-balance | Neraca Saldo | Saldo debit dan kredit semua akun | – |
| /reports/income-statement | reports.income-statement | Laba Rugi | Pendapatan, HPP, dan beban per periode | – |
| /reports/aging | reports.aging | Umur Piutang & Hutang | Umur piutang dan hutang | – |
| /reports/inventory-valuation | reports.inventory-valuation | Nilai Persediaan | Nilai persediaan per gudang dan produk | – |

Module roots (`/master-data`, `/inventory`, `/purchasing`, `/sales`, `/accounting`, `/reports`) redirect 302 → halaman pertama. Legacy `?tab=<slug>` → halaman yang cocok; `/reports` mapping: `neraca-saldo`→trial-balance, `laba-rugi`→income-statement, `umur-piutang-hutang`→aging, `nilai-persediaan`→inventory-valuation.

View: `resources/views/<module>/<page>.blade.php` (dashboard tetap `dashboard/index.blade.php`). Tidak ada folder `partials/`.

---

## KPI Cards (hanya di halaman berikut)

| Halaman | Jumlah | Nilai |
| --- | ---: | --- |
| Dashboard | 4 | Nilai Persediaan Rp 1.482.500.000 (348 SKU di 4 gudang) · Penjualan Bulan Ini Rp 996.800.000 (90 sales order) · Piutang Jatuh Tempo Rp 118.400.000 (14 invoice) · Hutang Jatuh Tempo Rp 194.200.000 (9 tagihan) |
| Inventory › Stok | 4 | Total Fisik 14.820 Unit · Direservasi 2.150 Unit (14 sales order aktif) · Siap Jual 12.670 Unit · Nilai Persediaan Rp 1.482.500.000 (metode rata-rata bergerak) |
| Accounting › Jurnal Umum | 3 | Total Debit Rp 4.892.450.000 · Total Kredit Rp 4.892.450.000 · Selisih Rp 0 (Seimbang) |
| Accounting › Buku Besar | 4 | Saldo Awal Rp 1.400.000.000 · Total Debit Rp 815.217.000 · Total Kredit Rp 732.717.000 · Saldo Akhir Rp 1.482.500.000 (akun 11300) |
| Laporan › Neraca Saldo | 3 | Mutasi & saldo akhir debit = kredit (Rp 4.892.450.000) |
| Laporan › Laba Rugi | 4 | Pendapatan Rp 996.800.000 · Laba Kotor Rp 265.600.000 (26,6%) · Total Beban Rp 49.407.000 · Laba Bersih Rp 216.193.000 (21,7%) |
| Laporan › Umur Piutang & Hutang | 4 | Total Piutang Rp 412.600.000 · Total Hutang Rp 531.800.000 (+ ringkasan umur) |
| Laporan › Nilai Persediaan | 3 | Nilai Persediaan Rp 1.482.500.000 (sama dengan akun 11300) |

**Tanpa KPI card**: Purchasing (4 halaman), Sales (4 halaman), Master Data, Opname, Transfer, Periode. Nilai `Rp` di halaman tersebut hanya kolom per baris tabel (Nilai/Selisih/Jumlah/Total).

Format angka: `Rp 1.482.500.000`; tanggal `14 Okt 2026`. Aktivitas terbaru: "… diposting", bukan "disetujui".

---

## Kolom & Status per Halaman

### Dashboard
Tidak ada tombol header. KPI 4 kartu + tabel **Stok Menipis** (Produk, Gudang, Available, Stok Min, Status; aksi link "Lihat semua stok") + **Aktivitas Terbaru** (5 baris). Tidak ada Quick Actions bar.

### Master Data
| Halaman | Kolom | Filter | Status |
| --- | --- | --- | --- |
| Produk | SKU, Nama Produk, Satuan, Harga Beli, Harga Jual, Stok Min, Status, Aksi | Status (Semua/Aktif/Nonaktif) | Aktif / Nonaktif |
| Gudang | Kode, Nama Gudang, Alamat, Status, Aksi | Status | Aktif / Nonaktif |
| Mitra | Kode, Nama, Tipe, Kontak, Termin Bayar, Status, Aksi | Tipe (Semua, Customer, Supplier) | Customer / Supplier |
| Akun | Kode, Nama Akun, Tipe, Saldo Normal, Status, Aksi | Tipe (Aset, Kewajiban, Ekuitas, Pendapatan, HPP, Beban) | Aset/Kewajiban/…; baris **11110 Bank** (Aset, Debit, Aktif) |

Dibuang: Kategori + "Harga Beli Rata-Rata"; PIC/kapasitas/"Utama"; NPWP/Kota; "Saldo Terakhir".

### Inventory
| Halaman | Kolom | Filter | Status |
| --- | --- | --- | --- |
| Stok | SKU, Nama Produk, Gudang, On Hand, Reserved, Available, Rata-Rata, Nilai, Status, Aksi | Gudang, Status | Tersedia / Menipis / Kritis |
| Opname | No. Opname, Tanggal, Gudang, Jumlah Item, Selisih Nilai, Status, Dibuat Oleh, Aksi | Gudang, Status | Draft / Diposting / Dibalik |
| Transfer | No. Transfer, Tanggal, Gudang Asal, Gudang Tujuan, Jumlah Item, Nilai Stok, Status, Dibuat Oleh, Aksi | Gudang, Status | Draft / Diposting / Dibalik |

Tanpa state persetujuan opname (In Progress/Selesai/Disetujui) dan tanpa dua-step transfer (Dikirim/Terima Barang/In Transit).

### Purchasing
| Halaman | Kolom | Filter | Status |
| --- | --- | --- | --- |
| PO | No. PO, Tanggal, Supplier, Gudang Tujuan, Total, Status, Dibuat Oleh, Aksi | Status, Supplier | Dikonfirmasi / Parsial / Selesai / Dibatalkan |
| Penerimaan | No. Penerimaan, Tanggal, No. PO, Supplier, Gudang, Nilai, Tagihan, Status, Aksi | Status, Gudang | Draft / Diposting / Dibalik |
| Tagihan | No. Bill, Tanggal, Jatuh Tempo, No. Penerimaan, Supplier, Total, Sisa Tagihan, Status, Aksi | Status, Supplier | Terbuka / Dibayar Sebagian / Lunas (+Dibalik) |
| Pembayaran | No. Pembayaran, Tanggal, No. Bill, Supplier, Metode, Jumlah, Status, Dibuat Oleh, Aksi | Metode, Status | Diposting / Dibalik |

Satu kolom Status (Status Penerimaan/Status Tagihan dihapus dari PO). Tanpa Draft di filter PO. Tanpa filter akun Kas/Bank.

### Sales
| Halaman | Kolom | Filter | Status |
| --- | --- | --- | --- |
| SO | No. SO, Tanggal, Customer, Gudang Asal, Total, Status, Dibuat Oleh, Aksi | Status, Customer | Dikonfirmasi / Parsial / Selesai / Dibatalkan |
| Pengiriman | No. Pengiriman, Tanggal, No. SO, Customer, Gudang, Jumlah Item, Nilai HPP, Invoice, Status, Aksi | Status, Gudang | Diposting / Dibalik |
| Invoice | No. Invoice, Tanggal, Jatuh Tempo, No. Pengiriman, Customer, Total, Sisa Tagihan, Status, Aksi | Status (+Jatuh Tempo), Customer | Terbuka / Dibayar Sebagian / Lunas / Jatuh Tempo / Dibalik |
| Pembayaran | No. Pembayaran, Tanggal, No. Invoice, Customer, Metode, Jumlah, Status, Dibuat Oleh, Aksi | Metode, Status | Diposting / Dibalik |

Tanpa Expedisi/Kurir, "Dalam Perjalanan", Status Pengiriman/Status Invoice di SO, filter akun tujuan.

### Accounting
| Halaman | Kolom | Filter | Status |
| --- | --- | --- | --- |
| Jurnal Umum | expand(+), No. Jurnal, Tanggal, Keterangan, Dokumen Sumber, Total, Status, Aksi + detail row (Akun/Debit/Kredit) | Periode, Sumber (Otomatis/Manual) | Diposting / Dibalik (Draft dihapus) |
| Buku Besar | Tanggal, No. Jurnal, Keterangan, Dokumen, Debit, Kredit, Saldo, Aksi | Akun (11300 Persediaan, 11000 Kas, 51000 HPP), Periode | – |
| Periode | Periode, Rentang Tanggal, Jurnal, Total Debit, Total Kredit, Status, Ditutup Oleh, Ditutup Pada, Aksi | Tahun, Status | Terbuka / Ditutup (tanpa "Buka Kembali") |

### Laporan
| Halaman | Kolom | Filter |
| --- | --- | --- |
| Neraca Saldo | Kode Akun, Nama Akun, Mutasi Debit, Mutasi Kredit, Saldo Akhir Debit, Saldo Akhir Kredit | Periode, Tipe Akun |
| Laba Rugi | Kode Akun, Nama Akun, Oktober 2026, Jan–Okt 2026, Aksi | Periode |
| Umur Piutang & Hutang | Customer, Belum Jatuh Tempo, 1-30, 31-60, 61-90, >90 Hari, Total, Aksi | – |
| Nilai Persediaan | Gudang, Jumlah Item, Total On Hand, Nilai Persediaan, % dari Total, Aksi | – |

Tanpa tombol "Export PDF/Excel" dan "Cetak Laporan".

---

## Kosakata Status (baru → lama)

| Area | Baru | Lama (dibuang) |
| --- | --- | --- |
| PO/SO | Dikonfirmasi, Parsial, Selesai, Dibatalkan | Approved, Partial, Confirmed, Shipped, Invoiced, Completed, Cancelled, Draft |
| Penerimaan/Pengiriman/Opname/Transfer | Draft, Diposting, Dibalik | In Progress, Selesai, Disetujui, In Transit, Dikirim, Terima Barang |
| Pembayaran & Jurnal | Diposting, Dibalik | Valid, Batal, Draft |
| Tagihan & Invoice | Terbuka, Dibayar Sebagian, Lunas, Dibalik; "Jatuh Tempo" = badge/filter turunan (tanggal < hari ini & sisa > 0) | Belum Dibayar, Sebagian, Outstanding, Overdue, Paid |

Terminologi: Vendor→Supplier · Vendor Bill→Tagihan · Surat Jalan/DO→Pengiriman · Goods Receipt→Penerimaan · Mitra Bisnis→Mitra · Approved→Dikonfirmasi · Sisa Piutang/Hutang→Sisa Tagihan · Kategori Hutang→Kewajiban · Reports→Laporan · Accounts→Akun. Dipertahankan: Invoice, Dashboard, Purchase Order, Sales Order. Prefix: PO, GR, VB, PV, SO, DO, INV, RC, OP, TF, JRN.

Warna badge: hijau positif, amber parsial/warning, merah batal/overdue (`bg-rose-*`), abu netral.

---

## Phase 6 — Akun Bank

`database/seeders/DatabaseSeeder.php` mengupsert akun **11110 Bank** (Aset, Debit) guarded `Schema::hasTable` — tanpa tabel akun di migration (repo tanpa migration business), seeder no-op saat ini; baris tampil di halaman Akun (view sample). Pembayaran sample tetap di 11100 → total tidak berubah. Tanpa UI pemilihan akun bank.
