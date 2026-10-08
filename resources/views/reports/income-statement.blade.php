@extends('layouts.app')
@section('title', 'Laba Rugi')
@section('content')
<x-ui.page-header />
<div class="space-y-4">

  
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Pendapatan</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 996.800.000</span>
      <span class="text-xs text-slate-400 mt-1">Periode Oktober 2026</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Laba Kotor</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 265.600.000</span>
      <span class="text-xs text-slate-400 mt-1">Margin 26,6%</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Total Beban</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 49.407.000</span>
      <span class="text-xs text-slate-400 mt-1">Di luar HPP</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Laba Bersih</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 216.193.000</span>
      <span class="text-xs text-slate-400 mt-1">Margin 21,7%</span>
    </div>
  </div>

  
  <div class="bg-white border rounded-lg p-4 flex flex-wrap justify-between items-center gap-3">
    <div class="flex flex-wrap items-center gap-3">
      <select class="h-9 px-3 border rounded-lg text-sm">
        <option>Periode: Oktober 2026</option>
        <option>September 2026</option>
        <option>Agustus 2026</option>
      </select>
    </div>
    <div class="text-sm text-slate-500">Dihitung dari jurnal yang sudah diposting</div>
  </div>

  
  <div class="bg-white border rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm table-fixed">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr class="h-10">
            <th class="py-3.5 px-4 text-left w-36 font-semibold">Kode Akun</th>
            <th class="py-3.5 px-4 text-left font-semibold">Nama Akun</th>
            <th class="py-3.5 px-4 text-right w-56 font-semibold">Oktober 2026</th>
            <th class="py-3.5 px-4 text-right w-56 font-semibold">Jan - Okt 2026</th>
            <th class="py-3.5 px-4 text-center w-14 font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y text-slate-800">
          
          <tr class="bg-slate-50 h-[52px]"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4 font-semibold uppercase tracking-wider text-slate-500">PENDAPATAN</td><td class="py-3.5 px-4 text-right"></td><td class="py-3.5 px-4 text-right"></td><td class="py-3.5 px-4 text-center"></td></tr>
          <tr class="hover:bg-slate-50 h-[52px]"><td class="py-3.5 px-4 font-mono text-xs">41000</td><td class="py-3.5 px-4">Pendapatan Penjualan</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 996.800.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 9.232.378.000</td><td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary" title="Lihat Buku Besar"><span class="material-symbols-outlined text-lg">visibility</span></button></td></tr>
          <tr class="bg-slate-100 h-[52px]"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4 font-semibold">Total Pendapatan</td><td class="py-3.5 px-4 text-right font-semibold tabular-nums">Rp 996.800.000</td><td class="py-3.5 px-4 text-right font-semibold tabular-nums">Rp 9.232.378.000</td><td class="py-3.5 px-4 text-center"></td></tr>

          
          <tr class="bg-slate-50 h-[52px]"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4 font-semibold uppercase tracking-wider text-slate-500">HARGA POKOK PENJUALAN</td><td class="py-3.5 px-4 text-right"></td><td class="py-3.5 px-4 text-right"></td><td class="py-3.5 px-4 text-center"></td></tr>
          <tr class="hover:bg-slate-50 h-[52px]"><td class="py-3.5 px-4 font-mono text-xs">51000</td><td class="py-3.5 px-4">Harga Pokok Penjualan</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 731.200.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 6.946.600.000</td><td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary" title="Lihat Buku Besar"><span class="material-symbols-outlined text-lg">visibility</span></button></td></tr>
          <tr class="bg-blue-50 h-[52px]"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4 font-semibold text-slate-900">Laba Kotor</td><td class="py-3.5 px-4 text-right font-semibold tabular-nums text-slate-900">Rp 265.600.000</td><td class="py-3.5 px-4 text-right font-semibold tabular-nums text-slate-900">Rp 2.285.778.000</td><td class="py-3.5 px-4 text-center"></td></tr>

          
          <tr class="bg-slate-50 h-[52px]"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4 font-semibold uppercase tracking-wider text-slate-500">BEBAN</td><td class="py-3.5 px-4 text-right"></td><td class="py-3.5 px-4 text-right"></td><td class="py-3.5 px-4 text-center"></td></tr>
          <tr class="hover:bg-slate-50 h-[52px]"><td class="py-3.5 px-4 font-mono text-xs">52100</td><td class="py-3.5 px-4">Selisih Persediaan</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 807.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 7.087.000</td><td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary" title="Lihat Buku Besar"><span class="material-symbols-outlined text-lg">visibility</span></button></td></tr>
          <tr class="hover:bg-slate-50 h-[52px]"><td class="py-3.5 px-4 font-mono text-xs">61100</td><td class="py-3.5 px-4">Beban Operasional Umum</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 48.600.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 438.300.000</td><td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary" title="Lihat Buku Besar"><span class="material-symbols-outlined text-lg">visibility</span></button></td></tr>
          <tr class="bg-slate-100 h-[52px]"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4 font-semibold">Total Beban</td><td class="py-3.5 px-4 text-right font-semibold tabular-nums">Rp 49.407.000</td><td class="py-3.5 px-4 text-right font-semibold tabular-nums">Rp 445.387.000</td><td class="py-3.5 px-4 text-center"></td></tr>

          
          <tr class="bg-slate-200 border-t-2 border-slate-300 h-[56px] font-semibold text-slate-900"><td class="py-3.5 px-4"></td><td class="py-3.5 px-4">Laba Bersih</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 216.193.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 1.840.391.000</td><td class="py-3.5 px-4 text-center"></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
