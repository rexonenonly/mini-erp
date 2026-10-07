@extends('layouts.app')
@section('title', 'Master Data - Chart of Accounts')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Master Data</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola produk, gudang, partner, dan akun</p>
    </div>
    <button class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
      <span class="material-symbols-outlined text-lg">add</span>
      <span>Akun Baru</span>
    </button>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="/master-data/products" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2"><span>Produk</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">348</span></a>
      <a href="/master-data/warehouses" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2"><span>Gudang</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">4</span></a>
      <a href="/master-data/partners" class="pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2"><span>Partner</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">5</span></a>
      <a href="/master-data/accounts" class="pb-3 border-b-2 border-primary text-primary font-semibold flex items-center gap-2"><span>Chart of Accounts</span><span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-50 text-primary border border-blue-100">10</span></a>
    </nav>
  </div>

  <div class="bg-white border rounded-lg">
    <div class="p-5 border-b flex justify-between items-center">
      <div class="flex gap-3">
        <input type="text" placeholder="Cari no akun atau nama akun..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
        <select class="h-9 px-3 border rounded-lg text-sm">
          <option>Tipe: Semua</option>
          <option>Aset</option>
          <option>Kewajiban</option>
          <option>Ekuitas</option>
          <option>Pendapatan</option>
          <option>HPP</option>
          <option>Beban</option>
        </select>
      </div>
      <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">10</span> dari <span class="font-medium">10</span> akun</div>
    </div>

    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
        <tr>
          <th class="py-3.5 px-3 text-left w-32">Kode</th>
          <th class="py-3.5 px-3 text-left">Nama Akun</th>
          <th class="py-3.5 px-3 text-left w-36">Tipe</th>
          <th class="py-3.5 px-3 text-left w-36">Saldo Normal</th>
          <th class="py-3.5 px-3 text-center w-24">Status</th>
          <th class="py-3.5 px-3 text-center w-16">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-3 font-mono text-sm">11100</td>
          <td class="py-3.5 px-3 font-medium">Kas Operasional</td>
          <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">Aset</span></td>
          <td class="py-3.5 px-3">Debit</td>
          <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
        </tr>
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-3 font-mono text-sm">11200</td>
          <td class="py-3.5 px-3 font-medium">Piutang Usaha</td>
          <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">Aset</span></td>
          <td class="py-3.5 px-3">Debit</td>
          <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
        </tr>
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-3 font-mono text-sm">11300</td>
          <td class="py-3.5 px-3 font-medium">Persediaan Barang Dagang</td>
          <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">Aset</span></td>
          <td class="py-3.5 px-3">Debit</td>
          <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
          <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
