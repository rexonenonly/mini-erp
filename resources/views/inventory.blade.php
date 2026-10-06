@extends('layouts.dashboard')
@section('title', 'Inventory')
@section('page-title', 'Inventory')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Inventory</h2>
      <p class="text-sm text-slate-500 mt-0.5">Pantau stok, reservasi, dan nilai persediaan per gudang</p>
    </div>
    <div class="flex gap-2">
      <button class="h-9 px-4 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">rule</span>
        Opname Stok
      </button>
      <button id="btnAction" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">add</span>
        <span id="btnLabel">Transfer Baru</span>
      </button>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#stok" data-tab="stok" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold">Stok</a>
      <a href="#opname" data-tab="opname" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Opname</a>
      <a href="#transfer" data-tab="transfer" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Transfer Stok</a>
    </nav>
  </div>

  <!-- TAB: STOK -->
  <div id="tab-stok" class="tab-content">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white border rounded-lg p-4">
        <div class="text-xs font-medium uppercase text-slate-500">Total Fisik (On Hand)</div>
        <div class="text-2xl font-semibold mt-2 text-slate-900">14.820 Unit</div>
        <div class="text-xs text-slate-500 mt-1">Di 4 gudang</div>
      </div>
      <div class="bg-white border rounded-lg p-4">
        <div class="text-xs font-medium uppercase text-slate-500">Direservasi</div>
        <div class="text-2xl font-semibold mt-2 text-slate-900">2.150 Unit</div>
        <div class="text-xs text-slate-500 mt-1">14 sales order aktif</div>
      </div>
      <div class="bg-white border rounded-lg p-4">
        <div class="text-xs font-medium uppercase text-slate-500">Siap Jual (Available)</div>
        <div class="text-2xl font-semibold mt-2 text-slate-900">12.670 Unit</div>
        <div class="text-xs text-slate-500 mt-1">On hand dikurangi reserved</div>
      </div>
      <div class="bg-white border rounded-lg p-4">
        <div class="text-xs font-medium uppercase text-slate-500">Nilai Persediaan</div>
        <div class="text-2xl font-semibold mt-2 text-slate-900">Rp 1.482.500.000</div>
        <div class="text-xs text-slate-500 mt-1">Metode rata-rata bergerak</div>
      </div>
    </div>

    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari SKU atau nama produk..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Gudang: Semua</option>
            <option>Gudang Utama</option>
            <option>Gudang Display</option>
            <option>Gudang Surabaya</option>
            <option>Gudang Transit</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Tersedia</option>
            <option>Menipis</option>
            <option>Kritis</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">392</span> baris stok</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-32">SKU</th>
              <th class="py-3.5 px-5 text-left">Nama Produk</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang</th>
              <th class="py-3.5 px-5 text-right w-24">On Hand</th>
              <th class="py-3.5 px-5 text-right w-24">Reserved</th>
              <th class="py-3.5 px-5 text-right w-24">Available</th>
              <th class="py-3.5 px-5 text-right w-28">Rata-Rata</th>
              <th class="py-3.5 px-5 text-right w-32">Nilai</th>
              <th class="py-3.5 px-5 text-center w-24">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SKU-ELC-091</td>
              <td class="py-3.5 px-5 font-medium">Kabel NYM 3x2.5mm (100m)</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">150 Roll</td>
              <td class="py-3.5 px-5 text-right">40 Roll</td>
              <td class="py-3.5 px-5 text-right font-medium">110 Roll</td>
              <td class="py-3.5 px-5 text-right">Rp 678.529</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 101.779.350</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Tersedia</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SKU-ELC-003</td>
              <td class="py-3.5 px-5 font-medium">MCB 1P 16A Schneider</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">12 Pcs</td>
              <td class="py-3.5 px-5 text-right">10 Pcs</td>
              <td class="py-3.5 px-5 text-right font-medium">2 Pcs</td>
              <td class="py-3.5 px-5 text-right">Rp 51.500</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 618.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-red-50 text-red-700 border border-red-200">Kritis</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SKU-MEC-014</td>
              <td class="py-3.5 px-5 font-medium">Bearing Ball Industrial 6205</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">35 Pcs</td>
              <td class="py-3.5 px-5 text-right">27 Pcs</td>
              <td class="py-3.5 px-5 text-right font-medium">8 Pcs</td>
              <td class="py-3.5 px-5 text-right">Rp 145.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.075.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Menipis</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SKU-LUB-082</td>
              <td class="py-3.5 px-5 font-medium">Oli Pelumas Industri ISO-VG46</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right font-medium">24 Pail</td>
              <td class="py-3.5 px-5 text-right">15 Pail</td>
              <td class="py-3.5 px-5 text-right font-medium">9 Pail</td>
              <td class="py-3.5 px-5 text-right">Rp 1.150.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 27.600.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Menipis</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SKU-BLD-002</td>
              <td class="py-3.5 px-5 font-medium">Semen Mortar Skimcoat 40kg</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Transit</td>
              <td class="py-3.5 px-5 text-right font-medium">620 Sak</td>
              <td class="py-3.5 px-5 text-right">0 Sak</td>
              <td class="py-3.5 px-5 text-right font-medium">620 Sak</td>
              <td class="py-3.5 px-5 text-right">Rp 78.500</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 48.670.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Tersedia</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 79</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">79</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: OPNAME -->
  <div id="tab-opname" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor opname..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Gudang: Semua</option>
            <option>Gudang Utama</option>
            <option>Gudang Display</option>
            <option>Gudang Surabaya</option>
            <option>Gudang Transit</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">12</span> opname</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Opname</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang</th>
              <th class="py-3.5 px-5 text-right w-28">Jumlah Item</th>
              <th class="py-3.5 px-5 text-right w-32">Selisih Nilai</th>
              <th class="py-3.5 px-5 text-center w-24">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">OP-2026-10-0005</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Display</td>
              <td class="py-3.5 px-5 text-right">2 item</td>
              <td class="py-3.5 px-5 text-right">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">OP-2026-10-0004</td>
              <td class="py-3.5 px-5 text-slate-600">10 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right">-Rp 1.360.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">OP-2026-10-0003</td>
              <td class="py-3.5 px-5 text-slate-600">05 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right">3 item</td>
              <td class="py-3.5 px-5 text-right">+Rp 450.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">OP-2026-10-0002</td>
              <td class="py-3.5 px-5 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Display</td>
              <td class="py-3.5 px-5 text-right">2 item</td>
              <td class="py-3.5 px-5 text-right">+Rp 103.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">OP-2026-10-0001</td>
              <td class="py-3.5 px-5 text-slate-600">02 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Transit</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right">-Rp 157.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 3</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: TRANSFER -->
  <div id="tab-transfer" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor transfer..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Gudang: Semua</option>
            <option>Gudang Utama</option>
            <option>Gudang Display</option>
            <option>Gudang Transit</option>
            <option>Gudang Surabaya</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">9</span> transfer</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Transfer</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang Asal</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang Tujuan</th>
              <th class="py-3.5 px-5 text-right w-24">Jumlah Item</th>
              <th class="py-3.5 px-5 text-right w-28">Nilai Stok</th>
              <th class="py-3.5 px-5 text-center w-24">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">TF-2026-10-0005</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Utama</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right">2 item</td>
              <td class="py-3.5 px-5 text-right">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">TF-2026-10-0004</td>
              <td class="py-3.5 px-5 text-slate-600">11 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Transit</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 15.700.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">TF-2026-10-0003</td>
              <td class="py-3.5 px-5 text-slate-600">08 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Utama</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right">3 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 18.250.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">TF-2026-10-0002</td>
              <td class="py-3.5 px-5 text-slate-600">04 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Utama</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 3.090.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">TF-2026-10-0001</td>
              <td class="py-3.5 px-5 text-slate-600">02 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Transit</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.800.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5">Hasan</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 2</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const tabs = {
  stok: 'Transfer Baru',
  opname: 'Opname Baru',
  transfer: 'Transfer Baru'
};

document.querySelectorAll('.tab-link').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const tab = link.dataset.tab;

    document.querySelectorAll('.tab-link').forEach(l => {
      l.classList.remove('border-primary', 'text-primary', 'font-semibold');
      l.classList.add('border-transparent', 'text-slate-500');
    });
    link.classList.remove('border-transparent', 'text-slate-500');
    link.classList.add('border-primary', 'text-primary', 'font-semibold');

    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('tab-' + tab).classList.remove('hidden');

    document.getElementById('btnLabel').textContent = tabs[tab];
    history.replaceState(null, '', '#' + tab);
  });
});

// ponytail: init dari hash jika ada
const hash = location.hash.slice(1);
if (hash && tabs[hash]) {
  document.querySelector(`[data-tab="${hash}"]`).click();
}
</script>
@endsection
