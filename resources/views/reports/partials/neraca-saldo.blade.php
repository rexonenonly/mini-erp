{{-- Neraca Saldo --}}
<div id="tab-neraca-saldo" class="tab-content {{ request('tab') !== 'neraca-saldo' ? 'hidden' : '' }} space-y-4">

  {{-- KPI CARDS --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Total Mutasi Debit</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 4.892.450.000</span>
      <span class="text-xs text-slate-400 mt-1">Periode Oktober 2026</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Total Mutasi Kredit</span>
      <span class="text-xl font-semibold tabular-nums mt-2">Rp 4.892.450.000</span>
      <span class="text-xs text-slate-400 mt-1">Periode Oktober 2026</span>
    </div>
    <div class="bg-white border rounded-lg p-4 flex flex-col">
      <span class="text-xs uppercase tracking-wider text-slate-500">Selisih</span>
      <div class="flex items-center gap-2 mt-2">
        <span class="text-xl font-semibold tabular-nums">Rp 0</span>
        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Seimbang
        </span>
      </div>
      <span class="text-xs text-slate-400 mt-1">Debit sama dengan kredit</span>
    </div>
  </div>

  {{-- TOOLBAR --}}
  <div class="bg-white border rounded-lg p-4 flex flex-wrap justify-between items-center gap-3">
    <div class="flex flex-wrap items-center gap-3">
      <div class="relative">
        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
        <input type="text" placeholder="Cari kode atau nama akun..." class="w-72 h-9 pl-8 pr-3 border rounded-lg text-sm">
      </div>
      <select class="h-9 px-3 border rounded-lg text-sm">
        <option>Periode: Oktober 2026</option>
        <option>September 2026</option>
        <option>Agustus 2026</option>
      </select>
      <select class="h-9 px-3 border rounded-lg text-sm">
        <option>Tipe Akun: Semua</option>
        <option>Aset (1xxxx)</option>
        <option>Kewajiban (2xxxx)</option>
        <option>Ekuitas (3xxxx)</option>
        <option>Pendapatan (4xxxx)</option>
        <option>Beban (5xxxx & 6xxxx)</option>
      </select>
    </div>
    <div class="text-sm text-slate-500">Menampilkan 10 akun</div>
  </div>

  {{-- TABLE --}}
  <div class="bg-white border rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-4 text-left w-28">Kode Akun</th>
            <th class="py-3.5 px-4 text-left">Nama Akun</th>
            <th class="py-3.5 px-4 text-right w-44">Mutasi Debit</th>
            <th class="py-3.5 px-4 text-right w-44">Mutasi Kredit</th>
            <th class="py-3.5 px-4 text-right w-48">Saldo Akhir Debit</th>
            <th class="py-3.5 px-4 text-right w-48">Saldo Akhir Kredit</th>
          </tr>
        </thead>
        <tbody class="divide-y text-slate-800">
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">11100</td><td class="py-3.5 px-4 font-medium">Kas Operasional</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 934.200.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 643.059.000</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 771.141.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">11200</td><td class="py-3.5 px-4 font-medium">Piutang Usaha</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 996.800.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 934.200.000</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 412.600.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">11300</td><td class="py-3.5 px-4 font-medium">Persediaan Barang Dagang</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 815.217.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 732.717.000</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 1.482.500.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">21100</td><td class="py-3.5 px-4 font-medium">Hutang Usaha</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 594.459.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 770.457.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 531.800.000</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">21200</td><td class="py-3.5 px-4 font-medium">Barang Diterima Belum Ditagih (GR/IR)</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 770.457.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 814.507.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 44.050.000</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">31000</td><td class="py-3.5 px-4 font-medium">Modal Disetor</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 250.000.000</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">41000</td><td class="py-3.5 px-4 font-medium">Pendapatan Penjualan</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 996.800.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 9.232.378.000</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">51000</td><td class="py-3.5 px-4 font-medium">Harga Pokok Penjualan</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 731.200.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 6.946.600.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">52100</td><td class="py-3.5 px-4 font-medium">Selisih Persediaan</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 1.517.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 710.000</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 7.087.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td></tr>
          <tr class="hover:bg-slate-50"><td class="py-3.5 px-4 font-mono text-xs">61100</td><td class="py-3.5 px-4 font-medium">Beban Operasional Umum</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 48.600.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td><td class="py-3.5 px-4 text-right font-medium tabular-nums">Rp 438.300.000</td><td class="py-3.5 px-4 text-right tabular-nums text-slate-400">-</td></tr>
          <tr class="font-bold bg-slate-50 border-t-2 border-slate-300 text-slate-900"><td class="py-3.5 px-4" colspan="2">Total</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 4.892.450.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 4.892.450.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 10.058.228.000</td><td class="py-3.5 px-4 text-right tabular-nums">Rp 10.058.228.000</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>