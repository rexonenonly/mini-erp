@extends('layouts.app')
@section('title', 'Stok')
@section('content')
<div class="inventory-page">
<x-ui.page-header />
<div class="space-y-4">
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
    <div class="inventory-toolbar p-5 border-b flex justify-between items-center gap-3">
      <div class="flex flex-wrap gap-3 min-w-0">
        <input type="search" aria-label="Cari SKU atau nama produk" placeholder="Cari SKU atau nama produk..." class="w-72 h-9 pl-3 border border-slate-200 rounded-lg text-sm bg-white">
        <select aria-label="Filter gudang" class="h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white">

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
      <table class="inventory-table stock-table w-full text-sm">
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
          @forelse($balances as $item)
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">{{ $item->product->sku }}</td>
              <td class="py-3.5 px-5 font-medium">{{ $item->product->name }}</td>
              <td class="py-3.5 px-5 text-slate-600">{{ $item->warehouse->name }}</td>
              <td class="py-3.5 px-5 text-right font-medium">{{ $item->on_hand }} {{ $item->product->unit }}</td>
              <td class="py-3.5 px-5 text-right">{{ $item->reserved }} {{ $item->product->unit }}</td>
              <td class="py-3.5 px-5 text-right font-medium">{{ $item->available }} {{ $item->product->unit }}</td>
              <td class="py-3.5 px-5 text-right">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp {{ number_format($item->value, 0, ',', '.') }}</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">{{ ucfirst($item->status) }}</span></td>
              <td class="py-3.5 px-5 text-center whitespace-nowrap">
                @can('stock.view') <button onclick="openModal('view', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary" title="Lihat" aria-label="Lihat"><span class="material-symbols-outlined text-lg">visibility</span></button> @endcan
                @can('stock.update') <button onclick="openModal('edit', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary" title="Ubah" aria-label="Ubah"><span class="material-symbols-outlined text-lg">edit</span></button> @endcan
                @can('stock.delete') <button onclick="confirmDelete({{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-red-600" title="Hapus" aria-label="Hapus"><span class="material-symbols-outlined text-lg">delete</span></button> @endcan
              </td>
            </tr>
          @empty
            <tr><td colspan="10" class="px-5 py-8 text-center text-slate-500">Tidak ada data stok.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
      <div class="text-sm text-slate-500">Halaman 1 dari 79</div>
      <div class="flex items-center gap-1">
        <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
        <button class="w-8 h-8 bg-slate-900 text-white text-sm font-medium flex items-center justify-center">1</button>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
        <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">79</button>
        <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
const resource = 'stock';
const canCreate = @json(auth()->user()->can('stock.create'));
const canUpdate = @json(auth()->user()->can('stock.update'));
</script>
@endpush
@endsection
