@extends('layouts.app')
@section('title', 'Opname Stok')
@section('content')
<div class="inventory-page">
<x-ui.page-header />
<div class="bg-white border rounded-lg">
  <div class="inventory-toolbar p-5 border-b flex justify-between items-center gap-3">
    <div class="flex gap-3">
      <input type="search" aria-label="Cari nomor opname" placeholder="Cari nomor opname..." class="w-72 h-9 pl-3 border border-slate-200 rounded-lg text-sm bg-white">
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
    <table class="inventory-table w-full text-sm">
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
        @forelse($items as $item)
        <tr class="hover:bg-slate-50">
          <td class="py-3.5 px-5 font-mono text-xs">{{ $item->number }}</td>
          <td class="py-3.5 px-5 text-slate-600">{{ optional($item->opname_date)->format('d M Y') }}</td>
          <td class="py-3.5 px-5 font-medium">{{ $item->warehouse?->name ?? '-' }}</td>
          <td class="py-3.5 px-5 text-right">{{ $item->items_count }} item</td>
          <td class="py-3.5 px-5 text-right">-</td>
          <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">{{ ucfirst($item->status) }}</span></td>
          <td class="py-3.5 px-5">{{ $item->creator?->name ?? '-' }}</td>
          <td class="py-3.5 px-5 text-center whitespace-nowrap">
            @can('stock-opnames.view') <button onclick="openModal('view', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary" title="Lihat" aria-label="Lihat"><span class="material-symbols-outlined text-lg">visibility</span></button> @endcan
            @can('stock-opnames.update') <button onclick="openModal('edit', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary" title="Ubah" aria-label="Ubah"><span class="material-symbols-outlined text-lg">edit</span></button> @endcan
            @can('stock-opnames.delete') <button onclick="confirmDelete({{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-red-600" title="Hapus" aria-label="Hapus"><span class="material-symbols-outlined text-lg">delete</span></button> @endcan
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="px-5 py-8 text-center text-slate-500">Tidak ada data opname.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
    <div class="text-sm text-slate-500">Halaman 1 dari 3</div>
    <div class="flex items-center gap-1">
      <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
      <button class="w-8 h-8 bg-slate-900 text-white text-sm font-medium flex items-center justify-center">1</button>
      <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
      <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
      <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
    </div>
  </div>
</div>
@push('scripts')
<script>
const resource = 'stock-opnames';
const canCreate = @json(auth()->user()->can('stock-opnames.create'));
const canUpdate = @json(auth()->user()->can('stock-opnames.update'));
</script>
@endpush
@endsection
