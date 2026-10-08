@extends('layouts.app')
@section('title', $cfg['label'])
@section('content')
<x-ui.page-header :title="$cfg['label']" :subtitle="'Kelola data ' . strtolower($cfg['label'])" />

@if(session('success'))
  <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">{{ session('success') }}</div>
@endif

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
  <div class="p-5 border-b border-slate-200 flex flex-wrap justify-between items-center gap-3">
    <div class="flex gap-3">
      <div class="relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
        <input type="text" id="search" placeholder="Cari..." class="w-72 h-9 pl-9 pr-3 border border-slate-200 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
      </div>
    </div>
    <div class="flex items-center gap-3">
      <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">{{ $items->count() }}</span> dari <span class="font-medium text-slate-900">{{ $total }}</span> {{ strtolower($cfg['label']) }}</div>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm" id="dataTable">
      <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
        <tr>
          @if($resource === 'products')
            <th class="py-3.5 px-5 text-left w-40">SKU</th>
            <th class="py-3.5 px-5 text-left">Nama Produk</th>
            <th class="py-3.5 px-5 text-left w-24">Satuan</th>
            <th class="py-3.5 px-5 text-right w-36">Harga Beli</th>
            <th class="py-3.5 px-5 text-right w-36">Harga Jual</th>
            <th class="py-3.5 px-5 text-right w-28">Stok Min</th>
            <th class="py-3.5 px-5 text-center w-28">Status</th>
            <th class="py-3.5 px-5 text-center w-14">Aksi</th>
          @elseif($resource === 'warehouses')
            <th class="py-3.5 px-5 text-left w-32">Kode</th>
            <th class="py-3.5 px-5 text-left">Nama Gudang</th>
            <th class="py-3.5 px-5 text-left w-48">Alamat</th>
            <th class="py-3.5 px-5 text-left w-36">Telepon</th>
            <th class="py-3.5 px-5 text-center w-28">Status</th>
            <th class="py-3.5 px-5 text-center w-14">Aksi</th>
          @elseif($resource === 'partners')
            <th class="py-3.5 px-5 text-left w-32">Kode</th>
            <th class="py-3.5 px-5 text-left">Nama Mitra</th>
            <th class="py-3.5 px-5 text-center w-32">Tipe</th>
            <th class="py-3.5 px-5 text-left w-40">Kontak</th>
            <th class="py-3.5 px-5 text-center w-28">Status</th>
            <th class="py-3.5 px-5 text-center w-14">Aksi</th>
          @elseif($resource === 'accounts')
            <th class="py-3.5 px-5 text-left w-32">Kode</th>
            <th class="py-3.5 px-5 text-left">Nama Akun</th>
            <th class="py-3.5 px-5 text-center w-32">Tipe</th>
            <th class="py-3.5 px-5 text-right w-40">Saldo</th>
            <th class="py-3.5 px-5 text-center w-28">Status</th>
            <th class="py-3.5 px-5 text-center w-14">Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200">
        @forelse($items as $item)
          <tr class="h-[52px] hover:bg-slate-50">
            @if($resource === 'products')
              <td class="px-5 py-3.5 font-mono text-sm">{{ $item->sku }}</td>
              <td class="px-5 py-3.5 font-medium">{{ $item->name }}</td>
              <td class="px-5 py-3.5 text-slate-600">{{ $item->unit }}</td>
              <td class="px-5 py-3.5 text-right font-medium">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
              <td class="px-5 py-3.5 text-right font-medium">Rp {{ number_format($item->sale_price, 0, ',', '.') }}</td>
              <td class="px-5 py-3.5 text-right">{{ $item->min_stock }}</td>
            @elseif($resource === 'warehouses')
              <td class="px-5 py-3.5 font-mono text-sm">{{ $item->code }}</td>
              <td class="px-5 py-3.5 font-medium">{{ $item->name }}</td>
              <td class="px-5 py-3.5 text-slate-600 text-xs">{{ Str::limit($item->address, 40) }}</td>
              <td class="px-5 py-3.5 text-slate-600">{{ $item->phone }}</td>
            @elseif($resource === 'partners')
              <td class="px-5 py-3.5 font-mono text-sm">{{ $item->code }}</td>
              <td class="px-5 py-3.5 font-medium">{{ $item->name }}</td>
              <td class="px-5 py-3.5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">{{ ucfirst($item->type) }}</span></td>
              <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $item->phone }}</td>
            @elseif($resource === 'accounts')
              <td class="px-5 py-3.5 font-mono text-sm">{{ $item->code }}</td>
              <td class="px-5 py-3.5 font-medium">{{ $item->name }}</td>
              <td class="px-5 py-3.5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">{{ ucfirst($item->type) }}</span></td>
              <td class="px-5 py-3.5 text-right font-medium">Rp {{ number_format($item->balance, 0, ',', '.') }}</td>
            @endif
            <td class="px-5 py-3.5 text-center">
              @if($item->is_active)
                <span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
              @else
                <span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Nonaktif</span>
              @endif
            </td>
            <td class="px-5 py-3.5 text-center">
              @can($resource . '.update')
                <button onclick="openModal('edit', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary rounded hover:bg-slate-100" title="Ubah"><span class="material-symbols-outlined text-lg">edit</span></button>
              @endcan
            </td>
          </tr>
        @empty
          <tr class="h-[52px]"><td colspan="8" class="px-5 py-8 text-center text-slate-500">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($items->hasPages())
    <div class="p-4 border-t border-slate-200">{{ $items->links() }}</div>
  @endif
</div>

@push('scripts')
<script>
const resource = '{{ $resource }}';
const canCreate = {{ auth()->user()->can($resource . '.create') ? 'true' : 'false' }};
const canUpdate = {{ auth()->user()->can($resource . '.update') ? 'true' : 'false' }};
</script>
@endpush
@endsection
