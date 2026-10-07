@extends('layouts.dashboard')
@section('title', 'Purchasing')
@section('page-title', 'Purchasing')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Purchasing</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola pembelian dari pemesanan sampai pembayaran ke supplier</p>
    </div>
    <div class="flex gap-2">
      <button class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">add</span>
        <span id="btnLabel">Purchase Order Baru</span>
      </button>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#po" data-tab="po" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold">Purchase Order</a>
      <a href="#penerimaan" data-tab="penerimaan" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Penerimaan</a>
      <a href="#vendor-bill" data-tab="vendor-bill" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Vendor Bill</a>
      <a href="#pembayaran" data-tab="pembayaran" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Pembayaran</a>
    </nav>
  </div>

  <!-- TAB: PURCHASE ORDER -->
  <div id="tab-po" class="tab-content">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor PO atau supplier..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Dikonfirmasi</option>
            <option>Parsial</option>
            <option>Selesai</option>
            <option>Dibatalkan</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Supplier: Semua</option>
            <option>PT Schneider Electric Distribution</option>
            <option>PT Tembaga Nusantara</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">24</span> PO</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm purchasing-table">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-48">No. PO</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left">Supplier</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang Tujuan</th>
              <th class="py-3.5 px-5 text-right w-32">Total</th>
              <th class="py-3.5 px-5 text-center w-24">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PO-2026-10-0044</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 20.250.000</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5 text-slate-600">Budi</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PO-2026-10-0043</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.150.000</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-transparent text-slate-700 border border-slate-400">Dikonfirmasi</span></td>
              <td class="py-3.5 px-5 text-slate-600">Budi</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PO-2026-10-0042</td>
              <td class="py-3.5 px-5 text-slate-600">11 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 77.800.000</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Parsial</span></td>
              <td class="py-3.5 px-5 text-slate-600">Budi</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PO-2026-10-0041</td>
              <td class="py-3.5 px-5 text-slate-600">07 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 40.500.000</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span></td>
              <td class="py-3.5 px-5 text-slate-600">Budi</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PO-2026-10-0040</td>
              <td class="py-3.5 px-5 text-slate-600">02 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.575.000</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-rose-50 text-rose-700 border border-rose-200">Dibatalkan</span></td>
              <td class="py-3.5 px-5 text-slate-600">Budi</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 5</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">5</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: PENERIMAAN -->
  <div id="tab-penerimaan" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor penerimaan atau PO..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
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
            <option>Gudang Surabaya</option>
            <option>Gudang Transit</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">18</span> penerimaan</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm purchasing-table">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Penerimaan</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-40">No. PO</th>
              <th class="py-3.5 px-5 text-left">Supplier</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang</th>
              <th class="py-3.5 px-5 text-right w-32">Nilai</th>
              <th class="py-3.5 px-5 text-left w-32">Vendor Bill</th>
              <th class="py-3.5 px-5 text-center w-24">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0039</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0042</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 33.750.000</td>
              <td class="py-3.5 px-5 text-slate-500">-</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600">Draft</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0038</td>
              <td class="py-3.5 px-5 text-slate-600">12 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0042</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 44.050.000</td>
              <td class="py-3.5 px-5 text-slate-600 text-xs">Belum ditagih</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0037</td>
              <td class="py-3.5 px-5 text-slate-600">09 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0041</td>
              <td class="py-3.5 px-5 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 40.500.000</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">VB-2026-10-0018</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0036</td>
              <td class="py-3.5 px-5 text-slate-600">06 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0039</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 12.360.000</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">VB-2026-10-0017</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0035</td>
              <td class="py-3.5 px-5 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0038</td>
              <td class="py-3.5 px-5 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 9.600.000</td>
              <td class="py-3.5 px-5 text-slate-500">-</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 4</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">4</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: VENDOR BILL -->
  <div id="tab-vendor-bill" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor bill atau supplier..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Terbuka</option>
            <option>Dibayar Sebagian</option>
            <option>Lunas</option>
            <option>Dibalik</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Supplier: Semua</option>
            <option>PT Schneider Electric Distribution</option>
            <option>PT Tembaga Nusantara</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">17</span> bill</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm purchasing-table">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-44">No. Bill</th>
              <th class="py-3.5 px-4 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-4 text-left w-28">Jatuh Tempo</th>
              <th class="py-3.5 px-4 text-left w-40">No. Penerimaan</th>
              <th class="py-3.5 px-4 text-left">Supplier</th>
              <th class="py-3.5 px-4 text-right w-32">Total</th>
              <th class="py-3.5 px-4 text-right w-32">Sisa Tagihan</th>
              <th class="py-3.5 px-4 text-center w-28">Status</th>
              <th class="py-3.5 px-4 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">VB-2026-10-0018</td>
              <td class="py-3.5 px-4 text-slate-600">10 Okt 2026</td>
              <td class="py-3.5 px-4 text-slate-600">09 Nov 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">GR-2026-10-0037</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 40.500.000</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 40.500.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex px-2.5 py-0.5 rounded-full text-xs border border-slate-300 text-slate-700 bg-white">Terbuka</span></td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">VB-2026-10-0017</td>
              <td class="py-3.5 px-4 text-slate-600">07 Okt 2026</td>
              <td class="py-3.5 px-4 text-slate-600">06 Nov 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">GR-2026-10-0036</td>
              <td class="py-3.5 px-4 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 12.360.000</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 6.360.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-amber-50 text-amber-800 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Dibayar Sebagian</span></td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">VB-2026-10-0016</td>
              <td class="py-3.5 px-4 text-slate-600">01 Okt 2026</td>
              <td class="py-3.5 px-4 text-slate-600">31 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">GR-2026-10-0034</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 27.000.000</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 0</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-800 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Lunas</span></td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">VB-2026-10-0015</td>
              <td class="py-3.5 px-4 text-slate-600">28 Sep 2026</td>
              <td class="py-3.5 px-4 text-slate-600">28 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">GR-2026-10-0033</td>
              <td class="py-3.5 px-4 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 8.240.000</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 0</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-800 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Lunas</span></td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">VB-2026-10-0014</td>
              <td class="py-3.5 px-4 text-slate-600">25 Sep 2026</td>
              <td class="py-3.5 px-4 text-slate-600">25 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">GR-2026-10-0032</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 15.300.000</td>
              <td class="py-3.5 px-4 text-right text-slate-400">-</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-amber-50 text-amber-800 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Dibalik</span></td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 4</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">4</button>
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
          <input type="text" placeholder="Cari nomor pembayaran atau bill..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Metode: Semua</option>
            <option>Transfer Bank</option>
            <option>Tunai</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">14</span> pembayaran</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm purchasing-table">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-44">No. Pembayaran</th>
              <th class="py-3.5 px-4 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-4 text-left w-40">No. Bill</th>
              <th class="py-3.5 px-4 text-left">Supplier</th>
              <th class="py-3.5 px-4 text-left w-32">Metode</th>
              <th class="py-3.5 px-4 text-right w-32">Jumlah</th>
              <th class="py-3.5 px-4 text-center w-24">Status</th>
              <th class="py-3.5 px-4 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-4 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0010</td>
              <td class="py-3.5 px-4 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0017</td>
              <td class="py-3.5 px-4 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 6.000.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0009</td>
              <td class="py-3.5 px-4 text-slate-600">09 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0016</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 12.000.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0008</td>
              <td class="py-3.5 px-4 text-slate-600">04 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0016</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 15.000.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0007</td>
              <td class="py-3.5 px-4 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0015</td>
              <td class="py-3.5 px-4 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-4 text-slate-600">Tunai</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 8.240.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0006</td>
              <td class="py-3.5 px-4 text-slate-600">27 Sep 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0014</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 15.300.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-rose-50 text-rose-700 border border-rose-200"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Dibalik</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
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
</div>

<script>
const tabs = {
  'po': 'Purchase Order Baru',
  'penerimaan': 'Penerimaan Baru',
  'vendor-bill': 'Vendor Bill Baru',
  'pembayaran': 'Pembayaran Baru'
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
