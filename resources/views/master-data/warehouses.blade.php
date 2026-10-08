@extends('layouts.app')
@section('title', 'Gudang')
@section('content')
<x-ui.page-header />
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari kode atau nama gudang..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Status: Aktif</option>
            <option>Status: Nonaktif</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">4</span> dari <span class="font-medium">4</span> gudang</div>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-5 text-left w-40">Kode</th>
            <th class="py-3.5 px-5 text-left">Nama Gudang</th>
            <th class="py-3.5 px-5 text-left">Alamat</th>
            <th class="py-3.5 px-5 text-center w-28">Status</th>
            <th class="py-3.5 px-5 text-center w-20">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono">WH-UTM</td>
            <td class="py-3.5 px-5 font-medium">Gudang Utama</td>
            <td class="py-3.5 px-5 text-slate-600">Cikupa, Tangerang</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
@endsection
