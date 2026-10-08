@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
<x-ui.page-header />
<div class="space-y-4">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor pembayaran atau invoice..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Metode: Semua</option>
            <option>Tunai</option>
            <option>Transfer Bank</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">33</span> pembayaran</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Pembayaran</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-40">No. Invoice</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-left w-32">Metode</th>
              <th class="py-3.5 px-5 text-right w-32">Jumlah</th>
              <th class="py-3.5 px-5 text-center w-28">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0012</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-10-0055</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Tunai</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.480.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0011</td>
              <td class="py-3.5 px-5 text-slate-600">10 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-10-0054</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 6.000.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0010</td>
              <td class="py-3.5 px-5 text-slate-600">05 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-10-0053</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 5.400.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-rose-50 text-rose-700 border border-rose-200">Dibalik</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0009</td>
              <td class="py-3.5 px-5 text-slate-600">02 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-09-0046</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 9.800.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">RC-2026-10-0008</td>
              <td class="py-3.5 px-5 text-slate-600">01 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-slate-600">INV-2026-09-0045</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Tunai</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 2.150.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 7</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">7</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
@endsection
