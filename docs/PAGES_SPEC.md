# Dokumentasi Lengkap Modul & Tab Mini ERP

Dokumen ini berisi struktur lengkap seluruh halaman, modul, dan tab yang ada di dalam aplikasi **Mini ERP** (Laravel 10, Tailwind CSS, Blade). 
Dokumen ini disusun khusus sebagai acuan evaluasi produk, kaji ulang alur UI/UX, efisiensi fitur, dan simplifikasi untuk ditinjau bersama Claude / Tim Pengembang.

---

## Ringkasan Struktur Modul & Tab

| Modul | Tipe Halaman | Tab yang Tersedia | Jumlah KPI / Cards | Fitur Utama / Tabel |
| :--- | :--- | :--- | :---: | :--- |
| **1. Dashboard** | Single Page | *(Tidak ada tab)* | 4 Cards | Ringkasan Persediaan, Sales, Piutang, Hutang + Table Stok Menipis + Timeline Aktivitas |
| **2. Master Data** | Multi-Tab | Products, Warehouses, Partners, Accounts | 0 | Master Produk, Master Gudang, Master Kontak (Vendor/Customer), COA (Bagan Akun) |
| **3. Inventory** | Multi-Tab | Stock (Stok), Opname, Transfers (Transfer Stok) | 4 Cards | Rekap Fisik/Reserved/Available, Form/Tabel Opname, Transfer antar gudang |
| **4. Purchasing** | Multi-Tab | Orders (PO), Receipts (Penerimaan), Bills (Tagihan), Payments (Pembayaran) | 4 Cards | Lifecycle Pembelian lengkap: PO -> Good Receipt -> Supplier Bill -> Outgoing Payment |
| **5. Sales** | Multi-Tab | Orders (SO), Deliveries (Surat Jalan), Invoices (Invoice), Payments (Pelunasan) | 4 Cards | Lifecycle Penjualan lengkap: SO -> Delivery Order -> Sales Invoice -> Incoming Payment |
| **6. Accounting** | Multi-Tab | Journals (Jurnal Umum), Ledger (Buku Besar), Periods (Periode Akuntansi) | 3 Cards | Pencatatan Jurnal Manual/Otomatis, Ledger per Akun, Tutup Buku Periode |
| **7. Reports** | Multi-Tab | Trial Balance (Neraca Saldo), Income Statement (Laba Rugi), Aging (Umur Piutang/Hutang), Inventory Valuation (Nilai Persediaan) | 4 Cards | Laporan Keuangan & Operasional ERP |

---

## 1. Dashboard (`/dashboard`)
* **Tujuan**: Memberikan ringkasan eksekutif kesehatan bisnis secara real-time.
* **Header Aksi**: *(Tidak ada tombol header)*
* **KPI Cards (4 Card)**:
  1. **Nilai Persediaan**: `Rp 1.482.500.000` *(Subtext: 348 SKU di 4 gudang)*
  2. **Penjualan Bulan Ini**: `Rp 842.150.000` *(Subtext: 142 sales order • +12,4% vs bulan lalu)*
  3. **Piutang Jatuh Tempo**: `Rp 118.400.000` *(Subtext: 14 invoice)*
  4. **Hutang Jatuh Tempo**: `Rp 194.200.000` *(Subtext: 9 vendor bill)*
* **Komponen Utama**:
  * **Tabel Stok Menipis (Left - 65% width)**:
    * *Kolom*: Produk (Nama + SKU), Gudang, Available, Stok Min, Status (`Kritis` / `Menipis`).
    * *Aksi*: Link "Lihat semua stok".
  * **Aktivitas Terbaru (Right - 35% width)**:
    * Timeline feed (Penerimaan barang dari vendor, Invoice diterbitkan, Pembayaran diterima, Stock opname disetujui).
  * **Aksi Cepat (Quick Actions Bar)**:
    * Tombol shortcut: "+ Sales Order", "+ Purchase Order", "+ Penerimaan Barang", "+ Jurnal Manual".

---

## 2. Master Data (`/master-data`)
* **Tujuan**: Pengelolaan data acuan dasar aplikasi (Produk, Gudang, Mitra Bisnis, dan Bagan Akun).
* **Header Aksi**: Dynamic Button ID `#btnAction` (Teks berubah sesuai tab aktif: "Tambah Produk", "Tambah Gudang", "Tambah Mitra", "Tambah Akun").
* **Navigasi Tab**: `#produk`, `#gudang`, `#mitra`, `#akun`.

### Tab 2.1: Produk (`master-data/partials/products.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari SKU, nama produk, atau kategori..."
  * Dropdown Filter: Kategori (Semua, Elektrikal, Mekanikal, Pelumas)
  * Summary: "Menampilkan 4 dari 348 produk"
* **Tabel Master Produk**:
  * *Kolom*: SKU, Nama Produk, Kategori, Satuan, Harga Beli Rata-Rata, Harga Jual Base, Status (`Aktif` / `Nonaktif`), Aksi (Edit/Detail).

### Tab 2.2: Gudang (`master-data/partials/warehouses.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari kode atau nama gudang..."
  * Summary: "Menampilkan 4 gudang"
* **Tabel Master Gudang**:
  * *Kolom*: Kode Gudang, Nama Gudang, Lokasi/Alamat, Penanggung Jawab (PIC), Kapasitas/Jumlah Bin, Status (`Utama`, `Aktif`), Aksi.

### Tab 2.3: Mitra Bisnis (`master-data/partials/partners.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari nama mitra, kontak, atau NPWP..."
  * Dropdown Filter: Tipe (Semua Mitra, Customer, Vendor, Customer & Vendor)
  * Summary: "Menampilkan 4 dari 86 mitra"
* **Tabel Master Mitra**:
  * *Kolom*: Kode Mitra, Nama Perusahaan / Kontak, Tipe (`Customer` / `Vendor`), Email & Telepon, Kota, Termin Pembayaran (cth: `Net 30`), Status, Aksi.

### Tab 2.4: Bagan Akun / COA (`master-data/partials/accounts.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari kode akun atau nama akun..."
  * Dropdown Filter: Kelompok Akun (Semua, Aset Lancar, Kategori Hutang, Ekuitas, Pendapatan, Beban)
  * Summary: "Menampilkan 5 dari 62 akun"
* **Tabel COA**:
  * *Kolom*: Kode Akun (Mono font), Nama Akun, Tipe Akun, Normal Balance (`Debit` / `Kredit`), Saldo Terakhir, Status Akun (`Aktif`), Aksi.

---

## 3. Inventory / Persediaan (`/inventory`)
* **Tujuan**: Pemantauan jumlah fisik stok, alokasi reservasi sales order, pelaksanaan stock opname, dan pemindahan stok antar gudang.
* **Header Aksi**:
  * Tombol 1: "Opname Stok" (Secondary Button)
  * Tombol 2: "Transfer Baru" (`#btnAction` - Primary Button)
* **KPI Cards (4 Card)**:
  1. **Total Fisik (On Hand)**: `14.820 Unit` *(Di 4 gudang)*
  2. **Direservasi**: `2.150 Unit` *(14 sales order aktif)*
  3. **Siap Jual (Available)**: `12.670 Unit` *(On hand dikurangi reserved)*
  4. **Nilai Persediaan**: `Rp 1.482.500.000` *(Metode rata-rata bergerak)*
* **Navigasi Tab**: `#stok`, `#opname`, `#transfer`.

### Tab 3.1: Stok On Hand (`inventory/partials/stock.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari SKU atau nama produk..."
  * Select Gudang: Gudang: Semua, Gudang Utama, Display, Surabaya, Transit.
  * Select Status: Status: Semua, Tersedia, Menipis, Kritis.
  * Counter: "Menampilkan 5 dari 392 baris stok"
* **Tabel Stok**:
  * *Kolom*: SKU, Nama Produk, Gudang, On Hand, Reserved, Available, Rata-Rata (Harga Pokok), Nilai (Total HPP), Status (`Tersedia`, `Menipis`, `Kritis`), Aksi (Kartu Stok / History).

### Tab 3.2: Stock Opname (`inventory/partials/opname.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari no. opname atau gudang..."
  * Select Status: Status: Semua, Draft, In Progress, Selesai, Disetujui.
* **Tabel Opname**:
  * *Kolom*: No. Opname, Tanggal, Gudang, Petugas/PIC, Selisih (Unit & Rp), Status (`Disetujui`, `Draft`), Aksi (Detail/Approval).

### Tab 3.3: Transfer Stok (`inventory/partials/transfers.blade.php`)
* **Toolbar & Filter**:
  * Input Search: "Cari no. transfer atau item..."
  * Select Status: Status: Semua, In Transit, Selesai, Draft.
* **Tabel Transfer**:
  * *Kolom*: No. Transfer, Tanggal, Gudang Asal, Gudang Tujuan, Total Item, Status (`Dikirim`, `Selesai`, `Draft`), Aksi (Detail / Terima Barang).

---

## 4. Purchasing / Pembelian (`/purchasing`)
* **Tujuan**: Pengelolaan seluruh siklus pengadaan barang mulai dari pemesanan ke supplier, penerimaan barang di gudang, pencatatan faktur tagihan, hingga pelunasan pembayaran.
* **Header Aksi**: `#btnAction` (Label berubah sesuai tab: "Purchase Order Baru", "Penerimaan Baru", "Tagihan Baru", "Pembayaran Baru").
* **KPI Cards (4 Card)**:
  1. **Total PO Aktif**: `18 PO` *(Rp 452.100.000)*
  2. **Menunggu Diterima**: `6 PO` *(Barang dalam pengiriman)*
  3. **Tagihan Belum Dibatayarkan**: `Rp 194.200.000` *(9 vendor bill)*
  4. **Pembayaran Bulan Ini**: `Rp 320.500.000` *(Total pengeluaran kas/bank)*
* **Navigasi Tab**: `#po`, `#penerimaan`, `#tagihan`, `#pembayaran`.

### Tab 4.1: Purchase Order (`purchasing/partials/orders.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. PO atau supplier..."
  * Status Filter: Semua Status, Draft, Approved, Partial Received, Full Received, Cancelled.
* **Tabel PO**:
  * *Kolom*: No. PO, Tanggal, Supplier, Total Nilai, Status Penerimaan, Status Tagihan, Status PO (`Approved`, `Partial`, `Draft`), Aksi.

### Tab 4.2: Penerimaan Barang / Goods Receipt (`purchasing/partials/receipts.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. penerimaan atau PO..."
  * Select Gudang Penerima.
* **Tabel Penerimaan**:
  * *Kolom*: No. Penerimaan (GR), Tanggal Terima, No. PO Acuan, Supplier, Gudang Tujuan, Total Item (Qty Received), Status (`Selesai`, `Draft`), Aksi.

### Tab 4.3: Tagihan Supplier / Vendor Bills (`purchasing/partials/bills.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. bill atau no. invoice supplier..."
  * Status Filter: Belum Dibayar, Lunas, Jatuh Tempo.
* **Tabel Tagihan**:
  * *Kolom*: No. Tagihan Supplier, Tanggal Bill, Jatuh Tempo, Supplier, No. PO / GR, Total Tagihan, Sisa Tagihan, Status (`Belum Dibayar`, `Sebagian`, `Lunas`), Aksi.

### Tab 4.4: Pembayaran Supplier / Outgoing Payments (`purchasing/partials/payments.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. pembayaran atau supplier..."
  * Account Filter: Kas Utama, Bank BCA, Bank Mandiri.
* **Tabel Pembayaran**:
  * *Kolom*: No. Pembayaran, Tanggal, Supplier, Akun Kas/Bank, No. Tagihan Dibayar, Jumlah Dibayar, Metode (`Transfer Bank`, `Cek`, `Kas`), Aksi.

---

## 5. Sales / Penjualan (`/sales`)
* **Tujuan**: Pengelolaan alur transaksi penjualan dari pesanan customer (SO), pengeluaran barang (Surat Jalan), pengeluaran invoice, hingga pencatatan uang masuk.
* **Header Aksi**: `#btnAction` (Label berubah: "Sales Order Baru", "Pengiriman Baru", "Invoice Baru", "Pembayaran Baru").
* **KPI Cards (4 Card)**:
  1. **Total SO Aktif**: `24 SO` *(Rp 680.400.000)*
  2. **Menunggu Pengiriman**: `8 SO` *(Siap dikirim dari gudang)*
  3. **Piutang Belum Lunas**: `Rp 312.800.000` *(18 invoice aktif)*
  4. **Penerimaan Bulan Ini**: `Rp 842.150.000` *(Total kas/bank masuk)*
* **Navigasi Tab**: `#so`, `#pengiriman`, `#invoice`, `#pembayaran`.

### Tab 5.1: Sales Order (`sales/partials/orders.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. SO atau nama customer..."
  * Status Filter: Semua Status, Draft, Confirmed, Shipped, Invoiced, Completed.
* **Tabel SO**:
  * *Kolom*: No. SO, Tanggal Order, Customer, Total Nilai, Status Pengiriman (`Belum Dikirim`, `Dikirim Sebagian`, `Selesai`), Status Invoice, Status SO (`Confirmed`, `Draft`), Aksi.

### Tab 5.2: Surat Jalan / Delivery Orders (`sales/partials/deliveries.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. pengiriman atau SO..."
  * Select Gudang Asal.
* **Tabel Surat Jalan**:
  * *Kolom*: No. Surat Jalan (DO), Tanggal Pengiriman, No. SO Acuan, Customer, Gudang Asal, Expedisi / Kurir, Status (`Terkirim`, `Dalam Perjalanan`), Aksi.

### Tab 5.3: Invoice Penjualan (`sales/partials/invoices.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. invoice atau customer..."
  * Status Filter: Semua Status, Outstanding, Overdue, Paid.
* **Tabel Invoice**:
  * *Kolom*: No. Invoice, Tanggal, Tanggal Jatuh Tempo, Customer, No. SO / DO, Total Invoice, Sisa Piutang, Status (`Overdue`, `Outstanding`, `Paid`), Aksi.

### Tab 5.4: Penerimaan Pembayaran / Incoming Payments (`sales/partials/payments.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari no. penerimaan atau customer..."
  * Account Filter: Kas Kasir, Bank BCA, Bank Mandiri.
* **Tabel Pembayaran**:
  * *Kolom*: No. Pembayaran, Tanggal Terima, Customer, Akun Tujuan (Kas/Bank), No. Invoice Dibayar, Jumlah Diterima, Status (`Valid`, `Batal`), Aksi.

---

## 6. Accounting / Akuntansi (`/accounting`)
* **Tujuan**: Pencatatan pembukuan ganda (double-entry), peninjauan jurnal umum, analisa buku besar per akun, dan pengelolaan tutup buku periode.
* **Header Aksi**: `#btnAction` (Label berubah: "Jurnal Manual Baru", "Filter Akun", "Tutup Periode Baru").
* **KPI Cards (3 Card)**:
  1. **Total Debit**: `Rp 4.892.450.000` *(Periode Oktober 2026)*
  2. **Total Kredit**: `Rp 4.892.450.000` *(Periode Oktober 2026)*
  3. **Status Balance (Selisih)**: `Rp 0` *(Badge: Seimbang / Balance)*
* **Navigasi Tab**: `#jurnal`, `#buku-besar`, `#periode`.

### Tab 6.1: Jurnal Umum (`accounting/partials/journals.blade.php`)
* **Toolbar & Filter**:
  * Search: "Cari nomor jurnal atau dokumen..."
  * Select Periode: Oktober 2026, September 2026, dst.
  * Select Sumber: Semua, Otomatis (dari Sales/Purchase/Inventory), Manual.
* **Tabel Jurnal & Expandable Detail Row**:
  * *Kolom Utama*: Expand Toggle (+), No. Jurnal, Tanggal, Keterangan, Dokumen Sumber (SO/DO/INV/GR), Total Debit/Kredit, Status (`Diposting` / `Draft`), Aksi.
  * *Detail Row (Accordion)*: Rincian baris debit/kredit per Kode Akun & Nama Akun.

### Tab 6.2: Buku Besar / General Ledger (`accounting/partials/ledger.blade.php`)
* **Toolbar & Filter**:
  * Select Akun COA: (11100 - Kas Utama, 11200 - Bank BCA, 11300 - Persediaan, dst.)
  * Select Rentang Tanggal / Periode.
* **Tabel Ledger**:
  * *Header Akun*: Kode Akun, Nama Akun, Saldo Awal.
  * *Kolom Tabel*: Tanggal, No. Referensi, Keterangan Transaksi, Debit, Kredit, Saldo Kumulatif.

### Tab 6.3: Periode Akuntansi (`accounting/partials/periods.blade.php`)
* **Toolbar & Filter**:
  * Summary Status Periode Aktif.
* **Tabel Periode**:
  * *Kolom*: Nama Periode (cth: `Oktober 2026`), Tanggal Mulai, Tanggal Selesai, Status (`Terbuka`, `Ditutup`), Ditutup Oleh / Tanggal Tutup, Aksi (Tutup Buku / Buka Kembali).

---

## 7. Reports / Laporan (`/reports`)
* **Tujuan**: Menyediakan laporan keuangan inti dan laporan analitis operasional untuk pengambilan keputusan eksekutif.
* **Header Aksi**:
  * Button 1: "Export PDF / Excel"
  * Button 2: "Cetak Laporan"
* **KPI Cards (4 Card)**:
  1. **Laba Bersih Bulan Ini**: `Rp 142.850.000` *(Margin 17.0%)*
  2. **Total Pendapatan**: `Rp 842.150.000` *(Sales bersih)*
  3. **Total HPP & Beban**: `Rp 699.300.000` *(Operasional & Pokok)*
  4. **Total Aset Persediaan**: `Rp 1.482.500.000` *(Nilai stok saat ini)*
* **Navigasi Tab**: `#neraca-saldo` (Trial Balance), `#laba-rugi` (Income Statement), `#aging` (Umur Piutang/Hutang), `#nilai-persediaan` (Inventory Valuation).

### Tab 7.1: Neraca Saldo / Trial Balance (`reports/partials/trial-balance.blade.php`)
* **Fungsi**: Memastikan keseimbangan saldo debit dan kredit seluruh akun sebelum laporan keuangan disusun.
* **Tabel Neraca Saldo**:
  * *Kolom*: Kode Akun, Nama Akun, Saldo Awal (Debit/Kredit), Mutasi Periode (Debit/Kredit), Saldo Akhir (Debit/Kredit).
  * *Footer Total*: Total Debit = Total Kredit (Seimbang).

### Tab 7.2: Laba Rugi / Income Statement (`reports/partials/income-statement.blade.php`)
* **Fungsi**: Menyajikan rincian Pendapatan Usaha, Harga Pokok Penjualan (HPP), Laba Kotor, Beban Operasional, dan Laba Bersih.
* **Struktur Laporan**:
  * Section 1: Pendapatan Penjualan (Rincian per akun pendapatan).
  * Section 2: Harga Pokok Penjualan (HPP).
  * *Subtotal*: **Laba Kotor (Gross Profit)**.
  * Section 3: Beban Operasional (Beban Gaji, Sewa, Listrik, Pemasaran, Umum).
  * *Total Akhir*: **Laba Bersih Sebelum Pajak (Net Income)**.

### Tab 7.3: Umur Piutang & Hutang / Aging Report (`reports/partials/aging.blade.php`)
* **Fungsi**: Menganalisis risiko arus kas berdasarkan keterlambatan pembayaran mitra (Customer & Vendor).
* **Tabel Aging**:
  * *Kolom*: Nama Mitra, Total Tagihan, Current (Belum Jatuh Tempo), 1-30 Hari, 31-60 Hari, 61-90 Hari, >90 Hari (Macet/Risk).

### Tab 7.4: Nilai Persediaan / Inventory Valuation (`reports/partials/inventory-valuation.blade.php`)
* **Fungsi**: Memerinci kuantitas fisik dan nilai nominal persediaan per kategori dan gudang.
* **Tabel Nilai Persediaan**:
  * *Kolom*: SKU, Nama Produk, Kategori, Gudang, Quantity On Hand, Unit Cost (HPP Rata-rata), Total Stock Value (Nilai Nominal), % dari Total Persediaan.

---

## Bahan Diskusi Kaji Ulang (Prompt untuk Claude)

Anda dapat menyalin pertanyaan-pertanyaan berikut saat berkonsultasi dengan Claude mengenai struktur UI di atas:

1. **Redundansi Metrik & Fitur**:
   * *Apakah ada KPI Card atau tabel yang tumpang tindih antara Dashboard, Inventory, dan Reports?* (Contoh: Nilai Persediaan muncul di Dashboard, Inventory, dan Reports).
2. **Kelengkapan Flow ERP**:
   * *Apakah alur transaksi (SO -> Delivery -> Invoice -> Payment) dan (PO -> Receipt -> Bill -> Payment) sudah cukup ideal untuk kelas Mini ERP, atau ada tahapan yang terlalu ribet / kurang lengkap?*
3. **Penyederhanaan UI/UX (Pemangkasan)**:
   * *Tab atau fitur mana yang sebaiknya disatukan atau dipangkas agar pengguna tidak bingung saat pertama kali menggunakan Mini ERP ini?*
4. **Konsistensi Penamaan & Istilah (Nomenklatur)**:
   * *Bagaimana saran perbaikan penamaan istilah bahasa (ID vs EN) di menu/tab agar konsisten bagi pengguna Indonesia?*

---
