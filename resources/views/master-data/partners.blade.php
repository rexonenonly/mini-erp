@extends('layouts.app')
@section('title', 'Master Data - Partner')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Master Data</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola produk, gudang, partner, dan akun</p>
    </div>
    <button class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
      <span class="material-symbols-outlined text-lg">add</span>
      <span>Partner Baru</span>
    </button>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="/master-data/products" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2"><span>Produk</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">348</span></a>
      <a href="/master-data/warehouses" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2"><span>Gudang</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">4</span></a>
      <a href="/master-data/partners" class="pb-3 border-b-2 border-primary text-primary font-semibold flex items-center gap-2"><span>Partner</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-50 text-primary border border-blue-100">5</span></a>
      <a href="/master-data/accounts" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2"><span>Chart of Accounts</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">10</span></a>
    </nav>
  </div>

  <div class="bg-white border rounded-lg">
    <div class="p-5 border-b flex justify-between items-center">
      <div class="flex gap-3">
        <input type="text" placeholder="Cari kode atau nama partner..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
        <div class="inline-flex rounded-lg border p-0.5 bg-slate-50">
          <button class="px-3 py-1 rounded text-xs font-medium bg-white shadow-sm border">Semua</button>
          <button class="px-3 py-1 rounded text-xs font-medium text-slate-600 hover:text-slate-900">Customer</button>
          <button class="px-3 py-1 rounded text-xs font-medium text-slate-600 hover:text-slate-900">Supplier</button>
        </div>
      </div>
      <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">5</span> partner</div>
    </div>

    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
        <tr>
          <th class="py-3.5 px-3 text-left w-32">Kode</th>
          <th class="py-3.5 px-3 text-left">Nama</th>
          <th class="py-3.5 px-3 text-left w-28">Tipe</th>
          <th class="py-3.5 px-3 text-left w-36">Kontak</th>
          <th class="py-3.5 px-3 text-left w-36">Termin Bayar</th>
          <th class="py-3.5 px-3 text-center w-24">Status</th>
          <th class="py-3.5 px-3 text-center w-16">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-3 font-mono text-sm">VEND-0124</td>
          <td class="py-3.5 px-3 font-medium">PT Schneider Electric Distribution</td>
          <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-blue-50 text-primary border border-blue-100">Supplier</span></td>
          <td class="py-3.5 px-3 font-mono text-sm text-slate-600">021-5551234</td>
          <td class="py-3.5 px-3">30 hari</td>
          <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
        </tr>
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-3 font-mono text-sm">CUST-0056</td>
          <td class="py-3.5 px-3 font-medium">PT Mega Konstruksi</td>
          <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">Customer</span></td>
          <td class="py-3.5 px-3 font-mono text-sm text-slate-600">021-5554321</td>
          <td class="py-3.5 px-3">30 hari</td>
          <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
