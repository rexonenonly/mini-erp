@extends('layouts.app')
@section('title', 'Penerimaan Barang')
@section('content')
<x-ui.page-header />
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor penerimaan atau PO..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Gudang: Semua</option>
            <option>Gudang Utama</option>
            <option>Gudang Display</option>
            <option>Gudang Surabaya</option>
            <option>Gudang Transit</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">18</span> penerimaan</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm purchasing-table">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Penerimaan</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-40">No. PO</th>
              <th class="py-3.5 px-5 text-left">Supplier</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang</th>
              <th class="py-3.5 px-5 text-right w-32">Nilai</th>
              <th class="py-3.5 px-5 text-left w-32">Tagihan</th>
              <th class="py-3.5 px-5 text-center w-24">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0039</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0042</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 33.750.000</td>
              <td class="py-3.5 px-5 text-slate-500">-</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600">Draft</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0038</td>
              <td class="py-3.5 px-5 text-slate-600">12 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0042</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 44.050.000</td>
              <td class="py-3.5 px-5 text-slate-600 text-xs">Belum ditagih</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0037</td>
              <td class="py-3.5 px-5 text-slate-600">09 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0041</td>
              <td class="py-3.5 px-5 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 40.500.000</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">VB-2026-10-0018</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0036</td>
              <td class="py-3.5 px-5 text-slate-600">06 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0039</td>
              <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 12.360.000</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">VB-2026-10-0017</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">GR-2026-10-0035</td>
              <td class="py-3.5 px-5 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs text-primary">PO-2026-10-0038</td>
              <td class="py-3.5 px-5 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 9.600.000</td>
              <td class="py-3.5 px-5 text-slate-500">-</td>
              <td class="py-3.5 px-5 text-center"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-rose-50 text-rose-700 border border-rose-200">Dibalik</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 4</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-slate-900 text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">4</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
@endsection
