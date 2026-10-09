@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
  <h1 class="text-2xl font-semibold text-slate-900 tracking-tight">Dashboard</h1>
  <p class="text-sm text-slate-500 mt-1">Ringkasan distribusi &amp; keuangan PT Distribusi Mandiri Utama</p>
</div>
<!-- a. ROW OF EXACTLY 4 KPI CARDS -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
  <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col justify-between">
    <div>
      <div class="text-xs font-medium text-slate-500 h-5 flex items-center">Nilai Persediaan</div>
      <div class="text-2xl font-semibold text-slate-900 my-2">Rp 1.482.500.000</div>
    </div>
    <div class="text-xs text-slate-500 pt-1">348 SKU di 4 gudang</div>
  </div>

  <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col justify-between">
    <div>
      <div class="text-xs font-medium text-slate-500 h-5 flex items-center">Penjualan Bulan Ini</div>
      <div class="text-2xl font-semibold text-slate-900 my-2">Rp {{ number_format($salesMTD->total ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="text-xs text-slate-500 flex items-center gap-1.5 pt-1">
      <span>{{ $salesMTD->count ?? 0 }} sales order</span>
      @if($pctChange != 0)
      <span class="text-slate-300">•</span>
      <span class="font-medium {{ $pctChange > 0 ? 'text-emerald-700 bg-emerald-50 border-emerald-100' : 'text-red-700 bg-red-50 border-red-100' }} px-1.5 py-0.5 rounded border text-xs">{{ $pctChange > 0 ? '+' : '' }}{{ number_format($pctChange, 1) }}% vs bulan lalu</span>
      @endif
    </div>
  </div>

  <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col justify-between">
    <div>
      <div class="text-xs font-medium text-slate-500 h-5 flex items-center">Piutang Jatuh Tempo</div>
      <div class="text-2xl font-semibold text-slate-900 my-2">Rp {{ number_format($overdueInvoices->total ?? 0, 0, ',', '.') }}</div>
    </div>
    <div class="text-xs text-slate-500 pt-1">{{ $overdueInvoices->count ?? 0 }} invoice</div>
  </div>

  <div class="bg-white border border-slate-200 rounded-lg p-5 flex flex-col justify-between">
    <div>
      <div class="text-xs font-medium text-slate-500 h-5 flex items-center">Hutang Jatuh Tempo</div>
      <div class="text-2xl font-semibold text-slate-900 my-2">Rp 194.200.000</div>
    </div>
    <div class="text-xs text-slate-500 pt-1">9 tagihan</div>
  </div>
</section>

<!-- b. TWO COLUMNS BELOW (Left 65% Stok Menipis, Right 35% Aktivitas Terbaru) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
  <!-- LEFT COLUMN -->
  <div class="lg:col-span-8 bg-white border border-slate-200 rounded-lg p-5">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Stok Menipis</h2>
        <p class="text-xs text-slate-500 mt-0.5">Daftar item dengan stok tersedia di bawah batas aman</p>
      </div>
      <a href="#" class="text-sm font-medium text-primary hover:text-primary-hover flex items-center gap-1">
        <span>Lihat semua stok</span>
        <span class="material-symbols-outlined text-base">arrow_forward</span>
      </a>
    </div>

    <div class="overflow-x-auto mt-2">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-200 text-slate-500 text-xs font-medium uppercase">
            <th class="py-3 px-3">Produk</th>
            <th class="py-3 px-3">Gudang</th>
            <th class="py-3 px-3 text-right">Available</th>
            <th class="py-3 px-3 text-right">Stok Min</th>
            <th class="py-3 px-3 text-center">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm">
          @forelse($lowStock as $item)
          <tr class="h-13 hover:bg-slate-50/70">
            <td class="py-2.5 px-3">
              <div class="font-medium text-slate-900">{{ $item->name }}</div>
              <div class="font-mono text-xs text-slate-500 mt-0.5">{{ $item->sku }}</div>
            </td>
            <td class="py-2.5 px-3 text-slate-600">{{ $item->warehouse }}</td>
            <td class="py-2.5 px-3 text-right font-medium text-slate-900">{{ $item->available }}</td>
            <td class="py-2.5 px-3 text-right text-slate-500">{{ $item->min_stock }}</td>
            <td class="py-2.5 px-3 text-center">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $item->available <= $item->min_stock / 2 ? 'bg-red-50 text-red-700 border-red-200' : 'bg-amber-50 text-amber-700 border-amber-200' }} border">{{ $item->available <= $item->min_stock / 2 ? 'Kritis' : 'Menipis' }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="py-8 text-center text-sm text-slate-500">Tidak ada stok menipis</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- RIGHT COLUMN -->
  <div class="lg:col-span-4 bg-white border border-slate-200 rounded-lg p-5">
    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Aktivitas Terbaru</h2>
        <p class="text-xs text-slate-500 mt-0.5">Pergerakan transaksi operasional hari ini</p>
      </div>
    </div>

    <div class="divide-y divide-slate-100">
      <div class="py-3.5 flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
          <span class="material-symbols-outlined text-lg">shopping_cart</span>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm text-slate-800 leading-snug">
            <span class="font-mono font-medium text-slate-900">PO-2026-10-0042</span> dikonfirmasi oleh Budi
          </div>
          <div class="text-xs text-slate-400 mt-0.5">14:24</div>
        </div>
      </div>

      <div class="py-3.5 flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
          <span class="material-symbols-outlined text-lg">inventory_2</span>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm text-slate-800 leading-snug">
            <span class="font-mono font-medium text-slate-900">GR-2026-10-0038</span> diposting oleh Hasan
          </div>
          <div class="text-xs text-slate-400 mt-0.5">14:18</div>
        </div>
      </div>

      <div class="py-3.5 flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
          <span class="material-symbols-outlined text-lg">point_of_sale</span>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm text-slate-800 leading-snug">
            <span class="font-mono font-medium text-slate-900">SO-2026-10-0089</span> dikonfirmasi, stok direservasi
          </div>
          <div class="text-xs text-slate-400 mt-0.5">14:02</div>
        </div>
      </div>

      <div class="py-3.5 flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
          <span class="material-symbols-outlined text-lg">fact_check</span>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm text-slate-800 leading-snug">
            <span class="font-mono font-medium text-slate-900">OP-2026-10-0004</span> diposting oleh Dewi
          </div>
          <div class="text-xs text-slate-400 mt-0.5">13:55</div>
        </div>
      </div>

      <div class="py-3.5 flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
          <span class="material-symbols-outlined text-lg">payments</span>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm text-slate-800 leading-snug">
            <span class="font-mono font-medium text-slate-900">RC-2026-10-0012</span> diterima dari Toko Sinar Teknik
          </div>
          <div class="text-xs text-slate-400 mt-0.5">13:40</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
