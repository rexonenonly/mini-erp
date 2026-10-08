@extends('layouts.app')
@section('title', 'Invoice')
@section('content')
<x-ui.page-header />
<div class="space-y-4">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor invoice atau customer..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Terbuka</option>
            <option>Dibayar Sebagian</option>
            <option>Lunas</option>
            <option>Jatuh Tempo</option>
            <option>Dibalik</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Customer: Semua</option>
            <option>Toko Sinar Teknik</option>
            <option>CV Citra Bangun Mandiri</option>
            <option>PT Mega Konstruksi</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">38</span> invoice</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Invoice</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-28">Jatuh Tempo</th>
              <th class="py-3.5 px-5 text-left w-40">No. Pengiriman</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-right w-32">Total</th>
              <th class="py-3.5 px-5 text-right w-32">Sisa Tagihan</th>
              <th class="py-3.5 px-5 text-center w-36">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0056</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">13 Nov 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0079</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.314.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.314.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs border border-slate-400 text-slate-700">Terbuka</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0055</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0080</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.480.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 0</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Lunas</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0054</td>
              <td class="py-3.5 px-5 text-slate-600">06 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">20 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0076</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 12.600.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 6.600.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibayar Sebagian</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0053</td>
              <td class="py-3.5 px-5 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-5 text-slate-600">02 Nov 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-10-0072</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.400.000</td>
              <td class="py-3.5 px-5 text-right">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-09-0048</td>
              <td class="py-3.5 px-5 text-slate-600">05 Sep 2026</td>
              <td class="py-3.5 px-5 text-slate-600">05 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">DO-2026-09-0071</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 24.000.000</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 24.000.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-rose-50 text-rose-700 border border-rose-200">Jatuh Tempo</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 8</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">8</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
@endsection
