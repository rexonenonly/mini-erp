@extends('layouts.dashboard')

@section('title', 'Master Data - Produk')

@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Master Data</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola produk, gudang, partner, dan akun</p>
    </div>
    <button class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
      <span class="material-symbols-outlined text-lg">add</span>
      <span>Produk Baru</span>
    </button>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="/master-data/products" class="pb-3 border-b-2 border-primary text-primary font-semibold flex items-center gap-2">
        <span>Produk</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-50 text-primary border border-blue-100">348</span>
      </a>
      <a href="/master-data/warehouses" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Gudang</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">4</span>
      </a>
      <a href="/master-data/partners" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Partner</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">5</span>
      </a>
      <a href="/master-data/accounts" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Chart of Accounts</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">10</span>
      </a>
    </nav>
  </div>

  <div class="bg-white border rounded-lg">
    <div class="p-5 border-b flex justify-between items-center">
      <div class="flex gap-3">
        <input type="text" placeholder="Cari SKU atau nama produk..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
        <select class="h-9 px-3 border rounded-lg text-sm">
          <option>Status: Semua</option>
          <option>Status: Aktif</option>
          <option>Status: Nonaktif</option>
        </select>
      </div>
      <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">8</span> dari <span class="font-medium">348</span> produk</div>
    </div>

    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
        <tr>
          <th class="py-3.5 px-5 text-left w-40">SKU</th>
          <th class="py-3.5 px-5 text-left">Nama Produk</th>
          <th class="py-3.5 px-5 text-left w-24">Satuan</th>
          <th class="py-3.5 px-5 text-right w-36">Harga Beli</th>
          <th class="py-3.5 px-5 text-right w-36">Harga Jual</th>
          <th class="py-3.5 px-5 text-right w-28">Stok Min</th>
          <th class="py-3.5 px-5 text-center w-28">Status</th>
          <th class="py-3.5 px-5 text-center w-24">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-5 font-mono text-sm">SKU-ELC-091</td>
          <td class="py-3.5 px-5 font-medium">Kabel NYM 3x2.5mm (100m)</td>
          <td class="py-3.5 px-5 text-slate-600">Roll</td>
          <td class="py-3.5 px-5 text-right font-medium">Rp 675.000</td>
          <td class="py-3.5 px-5 text-right font-medium">Rp 760.000</td>
          <td class="py-3.5 px-5 text-right">30</td>
          <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-5 text-center"><button class="text-primary hover:text-primary-hover text-sm font-medium">Ubah</button></td>
        </tr>
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-5 font-mono text-sm">SKU-ELC-003</td>
          <td class="py-3.5 px-5 font-medium">MCB 1P 16A Schneider</td>
          <td class="py-3.5 px-5 text-slate-600">Pcs</td>
          <td class="py-3.5 px-5 text-right font-medium">Rp 51.500</td>
          <td class="py-3.5 px-5 text-right font-medium">Rp 62.000</td>
          <td class="py-3.5 px-5 text-right">10</td>
          <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-5 text-center"><button class="text-primary hover:text-primary-hover text-sm font-medium">Ubah</button></td>
        </tr>
      </tbody>
    </table>

    <div class="px-5 py-4 border-t flex justify-between items-center">
      <div class="text-sm text-slate-500">Halaman <span class="font-medium text-slate-900">1</span> dari <span class="font-medium">44</span></div>
      <div class="flex gap-1">
        <button disabled class="h-8 px-3 rounded-lg border bg-slate-50 text-slate-400 text-sm">Sebelumnya</button>
        <button class="w-8 h-8 rounded-lg bg-primary text-white text-sm">1</button>
        <button class="w-8 h-8 rounded-lg border hover:bg-slate-50 text-sm">2</button>
        <button class="w-8 h-8 rounded-lg border hover:bg-slate-50 text-sm">3</button>
        <span class="px-1 text-slate-400">...</span>
        <button class="w-8 h-8 rounded-lg border hover:bg-slate-50 text-sm">44</button>
        <button class="h-8 px-3 rounded-lg border hover:bg-slate-50 text-sm">Selanjutnya</button>
      </div>
    </div>
  </div>
</div>
@endsection
