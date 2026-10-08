@extends('layouts.app')
@section('title', 'Jurnal Umum')
@section('content')
<x-ui.page-header />
<div class="space-y-4">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Total Debit</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 4.892.450.000</span>
      <span class="text-xs text-slate-400 mt-1">Periode Oktober 2026</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Total Kredit</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 4.892.450.000</span>
      <span class="text-xs text-slate-400 mt-1">Periode Oktober 2026</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Selisih</span>
      <div class="flex items-center gap-2 mt-2">
        <span class="text-xl font-semibold tabular-nums">Rp 0</span>
        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Seimbang</span>
      </div>
      <span class="text-xs text-slate-400 mt-1">Debit sama dengan kredit</span>
    </div>
  </div>
  <div class="bg-white border rounded-lg">
    <div class="p-4 border-b flex flex-wrap justify-between items-center gap-3">
      <div class="flex flex-wrap items-center gap-3">
        <div class="relative">
          <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
          <input type="text" placeholder="Cari nomor jurnal atau dokumen..." class="w-72 h-9 pl-8 pr-3 border rounded-lg text-sm">
        </div>
        <select class="h-9 px-3 border rounded-lg text-sm"><option>Periode: Oktober 2026</option><option>September 2026</option><option>Agustus 2026</option></select>
        <select class="h-9 px-3 border rounded-lg text-sm"><option>Sumber: Semua</option><option>Otomatis</option><option>Manual</option></select>
      </div>
      <div class="text-sm text-slate-500">Menampilkan 5 dari 242 jurnal</div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="w-10 text-center px-1"></th>
            <th class="py-3.5 px-4 text-left">No. Jurnal</th>
            <th class="py-3.5 px-4 text-left w-28">Tanggal</th>
            <th class="py-3.5 px-4 text-left">Keterangan</th>
            <th class="py-3.5 px-4 text-left w-32">Dokumen Sumber</th>
            <th class="py-3.5 px-4 text-right w-32">Total</th>
            <th class="py-3.5 px-4 text-center w-28">Status</th>
            <th class="w-16 text-center px-2">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="text-center"><button class="expand-btn text-slate-500 hover:text-slate-900" data-target="jrn-detail-1"><span class="material-symbols-outlined text-lg">expand_more</span></button></td>
            <td class="py-3.5 px-4 font-mono text-xs">JRN-2026-10-0216</td><td class="py-3.5 px-4 text-slate-600">14 Okt 2026</td><td class="py-3.5 px-4">Pengiriman barang ke PT Mega Konstruksi</td><td class="py-3.5 px-4 font-mono text-xs">DO-2026-10-0081</td><td class="py-3.5 px-4 text-right font-medium">Rp 13.570.580</td><td class="py-3.5 px-4 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td><td class="text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">open_in_new</span></button></td>
          </tr>
          <tr id="jrn-detail-1" class="bg-slate-50">
            <td colspan="8" class="p-0">
              <div class="px-12 py-3">
                <div class="bg-white rounded border overflow-hidden p-3">
                  <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-slate-400"><tr><th class="px-3 py-2 text-left">Akun</th><th class="px-3 py-2 text-right">Debit</th><th class="px-3 py-2 text-right">Kredit</th></tr></thead>
                    <tbody class="divide-y text-sm">
                      <tr><td class="px-3 py-2"><span class="font-mono text-xs">51000</span> - Harga Pokok Penjualan</td><td class="px-3 py-2 text-right">Rp 13.570.580</td><td class="px-3 py-2 text-right text-slate-400">-</td></tr>
                      <tr><td class="px-3 py-2"><span class="font-mono text-xs">11300</span> - Persediaan Barang Dagang</td><td class="px-3 py-2 text-right text-slate-400">-</td><td class="px-3 py-2 text-right">Rp 13.570.580</td></tr>
                    </tbody>
                    <tfoot><tr class="font-semibold bg-slate-50"><td class="px-3 py-2">Total</td><td class="px-3 py-2 text-right">Rp 13.570.580</td><td class="px-3 py-2 text-right">Rp 13.570.580</td></tr></tfoot>
                  </table>
                </div>
              </div>
            </td>
          </tr>
          <tr class="hover:bg-slate-50"><td class="text-center"><button class="expand-btn text-slate-500" data-target="jrn-detail-2"><span class="material-symbols-outlined text-lg">chevron_right</span></button></td><td class="py-3.5 px-4 font-mono text-xs">JRN-2026-10-0215</td><td class="py-3.5 px-4 text-slate-600">14 Okt 2026</td><td class="py-3.5 px-4">Invoice penjualan ke PT Mega Konstruksi</td><td class="py-3.5 px-4 font-mono text-xs">INV-2026-10-0056</td><td class="py-3.5 px-4 text-right font-medium">Rp 2.314.000</td><td class="py-3.5 px-4 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td><td class="text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">open_in_new</span></button></td></tr>
          <tr id="jrn-detail-2" class="hidden bg-slate-50"><td colspan="8" class="px-12 py-3 text-sm text-slate-500">Detail jurnal akan tampil di sini.</td></tr>
          <tr class="hover:bg-slate-50"><td class="text-center"><span class="material-symbols-outlined text-lg text-slate-300">chevron_right</span></td><td class="py-3.5 px-4 font-mono text-xs">JRN-2026-10-0194</td><td class="py-3.5 px-4 text-slate-600">12 Okt 2026</td><td class="py-3.5 px-4">Penerimaan barang dari PT Schneider Electric Distribution</td><td class="py-3.5 px-4 font-mono text-xs">GR-2026-10-0038</td><td class="py-3.5 px-4 text-right font-medium">Rp 44.050.000</td><td class="py-3.5 px-4 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td><td class="text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">open_in_new</span></button></td></tr>
          <tr class="hover:bg-slate-50"><td class="text-center"><span class="material-symbols-outlined text-lg text-slate-300">chevron_right</span></td><td class="py-3.5 px-4 font-mono text-xs">JRN-2026-10-0182</td><td class="py-3.5 px-4 text-slate-600">10 Okt 2026</td><td class="py-3.5 px-4">Selisih opname Gudang Utama</td><td class="py-3.5 px-4 font-mono text-xs">OP-2026-10-0004</td><td class="py-3.5 px-4 text-right font-medium">Rp 1.360.000</td><td class="py-3.5 px-4 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td><td class="text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">open_in_new</span></button></td></tr>
          <tr class="hover:bg-slate-50"><td class="text-center"><span class="material-symbols-outlined text-lg text-slate-300">chevron_right</span></td><td class="py-3.5 px-4 font-mono text-xs">JRN-2026-10-0150</td><td class="py-3.5 px-4 text-slate-600">08 Okt 2026</td><td class="py-3.5 px-4">Reklasifikasi biaya operasional</td><td class="py-3.5 px-4 text-slate-500">Manual</td><td class="py-3.5 px-4 text-right font-medium">Rp 2.500.000</td><td class="py-3.5 px-4 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td><td class="text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">undo</span></button></td></tr>
        </tbody>
      </table>
    </div>
    <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
      <div class="text-sm text-slate-500">Halaman 1 dari 49</div>
      <div class="flex items-center gap-1">
        <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
        <button class="w-8 h-8 bg-slate-900 text-white text-sm font-medium flex items-center justify-center">1</button>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
        <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">49</button>
        <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
      </div>
    </div>
  </div>
</div>
@endsection
