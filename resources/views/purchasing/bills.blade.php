@extends('layouts.app')
@section('title', 'Tagihan')
@section('content')
<x-ui.page-header title="Tagihan" subtitle="Kelola tagihan dari supplier" />

@if(session('success'))
  <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">{{ session('success') }}</div>
@endif

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
  <div class="p-5 border-b border-slate-200 flex flex-wrap justify-between items-center gap-3">
    <div class="flex gap-3">
      <div class="relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
        <input type="text" id="search" placeholder="Cari nomor bill atau supplier..." class="w-72 h-9 pl-9 pr-3 border border-slate-200 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
      </div>
    </div>
    <div class="flex items-center gap-3">
      <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">{{ $items->count() }}</span> dari <span class="font-medium text-slate-900">{{ $total }}</span> tagihan</div>
      @can('vendor-bills.create')
        <button type="button" onclick="openModal('create')" class="shrink-0 inline-flex items-center gap-1.5 h-9 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
          <span class="material-symbols-outlined text-lg">add</span><span>Tagihan Baru</span>
        </button>
      @endcan
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm" id="dataTable">
      <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
        <tr>
          <th class="py-3.5 px-5 text-left w-44">No. Bill</th>
          <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
          <th class="py-3.5 px-5 text-left w-28">Jatuh Tempo</th>
          <th class="py-3.5 px-5 text-left w-40">No. Penerimaan</th>
          <th class="py-3.5 px-5 text-left">Supplier</th>
          <th class="py-3.5 px-5 text-right w-32">Total</th>
          <th class="py-3.5 px-5 text-right w-32">Sisa Tagihan</th>
          <th class="py-3.5 px-5 text-center w-28">Status</th>
          <th class="py-3.5 px-5 text-center w-14">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200">
        @forelse($items as $item)
          <tr class="h-[52px] hover:bg-slate-50">
            <td class="px-5 py-3.5 font-mono text-xs">{{ $item->number }}</td>
            <td class="px-5 py-3.5 text-slate-600">{{ $item->bill_date->format('d M Y') }}</td>
            <td class="px-5 py-3.5 text-slate-600">{{ $item->due_date ? $item->due_date->format('d M Y') : '-' }}</td>
            <td class="px-5 py-3.5 font-mono text-xs text-primary">{{ $item->receipt->number ?? '-' }}</td>
            <td class="px-5 py-3.5 font-medium">{{ $item->supplier->name ?? '-' }}</td>
            <td class="px-5 py-3.5 text-right font-medium">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
            <td class="px-5 py-3.5 text-right font-medium">Rp {{ number_format(max($item->total_amount - $item->paid_amount, 0), 0, ',', '.') }}</td>
            <td class="px-5 py-3.5 text-center">@include('purchasing._status', ['status' => $item->status])</td>
            <td class="px-5 py-3.5 text-center whitespace-nowrap">
              @can('vendor-bills.view')
                <button onclick="openModal('view', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary rounded hover:bg-slate-100" title="Lihat" aria-label="Lihat"><span class="material-symbols-outlined text-lg">visibility</span></button>
              @endcan
              @can('vendor-bills.update')
                <button onclick="openModal('edit', {{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary rounded hover:bg-slate-100" title="Ubah" aria-label="Ubah"><span class="material-symbols-outlined text-lg">edit</span></button>
              @endcan
              @can('vendor-bills.delete')
                <button onclick="confirmDelete({{ $item->id }})" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-red-600 rounded hover:bg-red-50" title="Hapus" aria-label="Hapus"><span class="material-symbols-outlined text-lg">delete</span></button>
              @endcan
            </td>
          </tr>
        @empty
          <tr class="h-[52px]"><td colspan="9" class="px-5 py-8 text-center text-slate-500">Tidak ada data tagihan.</td></tr>
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
const resource = 'vendor-bills';
const canCreate = {{ auth()->user()->can('vendor-bills.create') ? 'true' : 'false' }};
const canUpdate = {{ auth()->user()->can('vendor-bills.update') ? 'true' : 'false' }};
</script>
@endpush
@endsection
