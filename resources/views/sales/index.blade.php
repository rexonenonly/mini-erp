@extends('layouts.app')
@section('title', 'Sales')
@section('page-title', 'Sales')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Sales</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola penjualan dari pesanan sampai pembayaran customer</p>
    </div>
    <div class="flex gap-2">
      <button class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">add</span>
        <span id="btnLabel">Sales Order Baru</span>
      </button>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#so" data-tab="so" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold">Sales Order</a>
      <a href="#pengiriman" data-tab="pengiriman" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Pengiriman</a>
      <a href="#invoice" data-tab="invoice" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Invoice</a>
      <a href="#pembayaran" data-tab="pembayaran" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Pembayaran</a>
    </nav>
  </div>

  <!-- TAB: SALES ORDER -->
  <div id="tab-so" class="tab-content">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor SO atau customer..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Dikonfirmasi</option>
            <option>Parsial</option>
            <option>Selesai</option>
            <option>Dibatalkan</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Customer: Semua</option>
            <option>Toko Sinar Teknik</option>
            <option>CV Citra Bangun Mandiri</option>
            <option>PT Mega Konstruksi</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">31</span> SO</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. SO</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang Asal</th>
              <th class="py-3.5 px-5 text-right w-32">Total</th>
              <th class="py-3.5 px-5 text-center w-32">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0090</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.100.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0089</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 30.400.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs border border-slate-400 text-slate-700">Dikonfirmasi</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0088</td>
              <td class="py-3.5 px-5 text-slate-600">12 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 7.120.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Parsial</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0087</td>
              <td class="py-3.5 px-5 text-slate-600">11 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 19.800.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs border border-slate-400 text-slate-700">Dikonfirmasi</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0074</td>
              <td class="py-3.5 px-5 text-slate-600">08 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 15.200.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 7</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">7</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: PENGIRIMAN -->
  <div id="tab-pengiriman" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor pengiriman atau SO..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Gudang: Semua</option>
            <option>Gudang Utama</option>
            <option>Gudang Display</option>
            <option>Gudang Transit</option>
            <option>Gudang Surabaya</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">27</span> pengiriman</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Pengiriman</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-40">No. SO</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang</th>
              <th class="py-3.5 px-5 text-right w-24">Jumlah Item</th>
              <th class="py-3.5 px-5 text-right w-32">Nilai HPP</th>
              <th class="py-3.5 px-5 text-left w-40">Invoice</th>
              <th class="py-3.5 px-5 text-center w-28">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0082</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0089</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">-</td>
              <td class="py-3.5 px-5 text-slate-400">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0081</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0074</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 13.570.580</td>
              <td class="py-3.5 px-5 text-slate-500">Belum ditagih</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0080</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0084</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right">2 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.220.000</td>
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0055</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0079</td>
              <td class="py-3.5 px-5 text-slate-600">12 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0088</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.885.000</td>
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0056</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0078</td>
              <td class="py-3.5 px-5 text-slate-600">09 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0081</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Transit</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 3.925.000</td>
              <td class="py-3.5 px-5 text-slate-400">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 6</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">6</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: INVOICE -->
  <div id="tab-invoice" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor invoice atau customer..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Terbuka</option>
            <option>Dibayar Sebagian</option>
            <option>Lunas</option>
            <option>Jatuh Tempo</option>
            <option>Dibalik</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Customer: Semua</option>
            <option>Toko Sinar Teknik</option>
            <option>CV Citra Bangun Mandiri</option>
            <option>PT Mega Konstruksi</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">38</span> invoice</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Invoice</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-28">Jatuh Tempo</th>
              <th class="py-3.5 px-5 text-left w-40">No. Pengiriman</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-right w-32">Total</th>
              <th class="py-3.5 px-5 text-right w-32">Sisa Tagihan</th>
              <th class="py-3.5 px-5 text-center w-36">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0056</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">13 Nov 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0079</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.314.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.314.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs border border-slate-400 text-slate-700">Terbuka</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0055</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0080</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.480.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 0</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Lunas</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0054</td>
              <td class="py-3.5 px-5 text-slate-600">06 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">20 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0076</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 12.600.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 6.600.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibayar Sebagian</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0053</td>
              <td class="py-3.5 px-5 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">02 Nov 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0072</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.400.000</td>
              <td class="py-3.5 px-5 text-right">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-09-0048</td>
              <td class="py-3.5 px-5 text-slate-600">05 Sep 2026</td>
              <td class="py-3.5 px-5 text-slate-600">05 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-09-0071</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 24.000.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 24.000.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-rose-50 text-rose-700 border border-rose-200">Jatuh Tempo</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 8</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">8</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: PEMBAYARAN -->
  <div id="tab-pembayaran" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor pembayaran atau invoice..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Metode: Semua</option>
            <option>Tunai</option>
            <option>Transfer Bank</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">33</span> pembayaran</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Pembayaran</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-40">No. Invoice</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-left w-32">Metode</th>
              <th class="py-3.5 px-5 text-right w-32">Jumlah</th>
              <th class="py-3.5 px-5 text-center w-28">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0012</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-10-0055</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Tunai</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.480.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0011</td>
              <td class="py-3.5 px-5 text-slate-600">10 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-10-0054</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 6.000.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0010</td>
              <td class="py-3.5 px-5 text-slate-600">05 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-10-0053</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.400.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0009</td>
              <td class="py-3.5 px-5 text-slate-600">02 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-09-0046</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 9.800.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0008</td>
              <td class="py-3.5 px-5 text-slate-600">01 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-09-0045</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Tunai</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.150.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 7</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">7</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const tabs = {
  so: 'Sales Order Baru',
  pengiriman: 'Pengiriman Baru',
  invoice: 'Invoice Baru',
  pembayaran: 'Pembayaran Baru'
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