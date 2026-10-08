@extends('layouts.app')
@section('title', 'Umur Piutang & Hutang')
@section('content')
<x-ui.page-header />
<div class="space-y-4">

  
  <div class="bg-white border rounded-lg p-4 flex flex-wrap justify-between items-center gap-4">
    <div class="flex items-center gap-3 flex-wrap">
      
      <div class="bg-slate-100 p-1 rounded-lg flex items-center shadow-inner">
        <button type="button" class="px-3 py-1.5 rounded-md text-xs font-medium bg-white text-slate-900 shadow-xs border border-slate-200" data-segment="piutang">Piutang</button>
        <button type="button" class="px-3 py-1.5 rounded-md text-xs font-medium text-slate-600 hover:text-slate-900" data-segment="hutang">Hutang</button>
      </div>
      
      <div class="relative">
        <button type="button" class="inline-flex items-center gap-2 bg-white border border-slate-200 rounded-md px-3 py-1.5 text-xs font-medium text-slate-800 hover:bg-slate-50 focus:outline-none transition-colors shadow-xs">
          <span class="material-symbols-outlined text-[16px] text-slate-500">calendar_today</span>
          <span>Per Tanggal: 14 Okt 2026</span>
          <span class="material-symbols-outlined text-[16px] text-slate-400">expand_more</span>
        </button>
      </div>
    </div>
    <div class="flex items-center gap-1.5 text-slate-500 text-xs">
      <span class="material-symbols-outlined text-[15px] text-slate-400">info</span>
      <span>Umur dihitung dari hari lewat jatuh tempo</span>
    </div>
  </div>

  
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Total Piutang</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 412.600.000</div>
      <span class="text-xs text-slate-500 mt-2 block">3 customer</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Belum Jatuh Tempo</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 294.200.000</div>
      <span class="text-xs text-slate-500 mt-2 block">Masih dalam termin</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Lewat Jatuh Tempo</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 118.400.000</div>
      <span class="text-xs text-slate-500 mt-2 block">14 invoice</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Lewat Lebih dari 60 Hari</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 22.000.000</div>
      <span class="text-xs text-slate-500 mt-2 block">Perlu ditagih segera</span>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Total Hutang</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 531.800.000</div>
      <span class="text-xs text-slate-500 mt-2 block">3 pemasok</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Belum Jatuh Tempo</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 294.200.000</div>
      <span class="text-xs text-slate-500 mt-2 block">Masih dalam termin</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Lewat Jatuh Tempo</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 196.200.000</div>
      <span class="text-xs text-slate-500 mt-2 block">9 tagihan pemasok</span>
    </div>
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-xs">
      <span class="text-xs font-medium text-slate-500 block">Lewat Lebih dari 60 Hari</span>
      <div class="text-2xl font-bold text-slate-900 mt-1 tabular-nums tracking-tight">Rp 41.400.000</div>
      <span class="text-xs text-slate-500 mt-2 block">Perlu dibayar segera</span>
    </div>
  </div>

  
  <div class="bg-white border border-slate-200 rounded-lg shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-200">
            <th class="py-3 px-4 text-left uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">Customer</th>
            <th class="py-3 px-4 text-right uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">Belum Jatuh Tempo</th>
            <th class="py-3 px-4 text-right uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">1-30 Hari</th>
            <th class="py-3 px-4 text-right uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">31-60 Hari</th>
            <th class="py-3 px-4 text-right uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">61-90 Hari</th>
            <th class="py-3 px-4 text-right uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">>90 Hari</th>
            <th class="py-3 px-4 text-right uppercase text-xs font-semibold text-slate-500 tracking-wider" scope="col">Total</th>
            <th class="py-3 px-2 text-center uppercase text-xs font-semibold text-slate-500 tracking-wider w-14" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm font-normal text-slate-800">
          <tr class="h-[52px] hover:bg-slate-50/70 transition-colors">
            <td class="py-3.5 px-4 align-middle text-sm font-medium text-slate-900 max-w-[220px]"><span class="line-clamp-2 leading-snug">PT Mega Konstruksi</span></td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 196.200.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 24.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 12.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 4.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 8.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm font-semibold text-slate-900 tabular-nums whitespace-nowrap">Rp 244.200.000</td>
            <td class="py-3.5 px-2 align-middle text-center w-14"><button class="inline-flex items-center justify-center w-8 h-8 rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" title="Lihat Rincian"><span class="material-symbols-outlined text-[19px]">visibility</span></button></td>
          </tr>
          <tr class="h-[52px] hover:bg-slate-50/70 transition-colors">
            <td class="py-3.5 px-4 align-middle text-sm font-medium text-slate-900 max-w-[220px]"><span class="line-clamp-2 leading-snug">CV Citra Bangun Mandiri</span></td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 98.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 10.400.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 8.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 4.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">-</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm font-semibold text-slate-900 tabular-nums whitespace-nowrap">Rp 120.400.000</td>
            <td class="py-3.5 px-2 align-middle text-center w-14"><button class="inline-flex items-center justify-center w-8 h-8 rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" title="Lihat Rincian"><span class="material-symbols-outlined text-[19px]">visibility</span></button></td>
          </tr>
          <tr class="h-[52px] hover:bg-slate-50/70 transition-colors">
            <td class="py-3.5 px-4 align-middle text-sm font-medium text-slate-900 max-w-[220px]"><span class="line-clamp-2 leading-snug">Toko Sinar Teknik</span></td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">-</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 28.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 14.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">Rp 6.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm text-slate-900 tabular-nums whitespace-nowrap">-</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm font-semibold text-slate-900 tabular-nums whitespace-nowrap">Rp 48.000.000</td>
            <td class="py-3.5 px-2 align-middle text-center w-14"><button class="inline-flex items-center justify-center w-8 h-8 rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" title="Lihat Rincian"><span class="material-symbols-outlined text-[19px]">visibility</span></button></td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="h-[52px] bg-slate-50/60 border-t-2 border-slate-300 font-bold text-slate-900">
            <td class="py-3.5 px-4 align-middle text-sm uppercase tracking-wide font-bold">Total</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm tabular-nums whitespace-nowrap font-bold">Rp 294.200.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm tabular-nums whitespace-nowrap font-bold">Rp 62.400.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm tabular-nums whitespace-nowrap font-bold">Rp 34.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm tabular-nums whitespace-nowrap font-bold">Rp 14.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm tabular-nums whitespace-nowrap font-bold">Rp 8.000.000</td>
            <td class="py-3.5 px-4 align-middle text-right text-sm tabular-nums whitespace-nowrap font-bold">Rp 412.600.000</td>
            <td class="py-3.5 px-2 align-middle text-center w-14"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endsection
