{{-- Nilai Persediaan --}}
<div id="tab-inventory-valuation" class="space-y-4">

  {{-- KPI CARDS (3 cards) --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white border rounded-lg p-5 flex flex-col justify-between">
      <span class="text-xs font-medium text-slate-500">Nilai Persediaan</span>
      <div class="my-2"><span class="text-2xl font-bold text-slate-900 tabular-nums tracking-tight whitespace-nowrap">Rp 1.482.500.000</span></div>
      <span class="text-xs text-slate-500">Metode rata-rata bergerak</span>
    </div>
    <div class="bg-white border rounded-lg p-5 flex flex-col justify-between">
      <span class="text-xs font-medium text-slate-500">Saldo Akun 11300</span>
      <div class="my-2 flex items-center gap-2">
        <span class="text-2xl font-bold text-slate-900 tabular-nums tracking-tight whitespace-nowrap">Rp 1.482.500.000</span>
        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Sesuai</span>
      </div>
      <span class="text-xs text-slate-500">Selisih Rp 0</span>
    </div>
    <div class="bg-white border rounded-lg p-5 flex flex-col justify-between">
      <span class="text-xs font-medium text-slate-500">Total On Hand</span>
      <div class="my-2"><span class="text-2xl font-bold text-slate-900 tabular-nums tracking-tight whitespace-nowrap">14.820 Unit</span></div>
      <span class="text-xs text-slate-500">348 SKU di 4 gudang</span>
    </div>
  </div>

  {{-- TOOLBAR --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
    <div class="flex items-center gap-3 flex-wrap">
      {{-- Segmented control --}}
      <div class="inline-flex bg-slate-100 p-0.5 rounded-md border border-slate-200/80 text-xs font-medium">
        <button type="button" class="px-3.5 py-1.5 rounded bg-white text-slate-900 font-semibold shadow-sm border border-slate-200/60" data-view="gudang">Per Gudang</button>
        <button type="button" class="px-3.5 py-1.5 rounded text-slate-600 hover:text-slate-900 transition-colors" data-view="produk">Per Produk</button>
      </div>
      {{-- Date dropdown --}}
      <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-md text-xs font-medium text-slate-700 shadow-sm">
        <span class="material-symbols-outlined text-[16px] text-slate-400">calendar_today</span>
        <span>Per Tanggal: 14 Okt 2026</span>
        <span class="material-symbols-outlined text-[16px] text-slate-400">expand_more</span>
      </div>
    </div>
    <div class="text-xs text-slate-500">Menampilkan 4 gudang</div>
  </div>

  {{-- TABLE --}}
  <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider h-11">
            <th class="py-3 px-5 font-semibold text-slate-600">Gudang</th>
            <th class="py-3 px-5 text-right font-semibold text-slate-600">Jumlah Item</th>
            <th class="py-3 px-5 text-right font-semibold text-slate-600">Total On Hand</th>
            <th class="py-3 px-5 text-right font-semibold text-slate-600">Nilai Persediaan</th>
            <th class="py-3 px-5 text-right font-semibold text-slate-600">% dari Total</th>
            <th class="py-3 px-4 w-14 text-center font-semibold text-slate-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-sm font-normal text-slate-800">
          <tr class="h-[52px] hover:bg-slate-50/60 transition-colors">
            <td class="py-3 px-5 align-middle font-medium text-slate-900">Gudang Utama</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">168</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap">7.350 Unit</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap font-medium">Rp 842.300.000</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">56,8%</td>
            <td class="py-3 px-4 align-middle text-center w-14"><button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition-colors" title="Lihat Produk"><span class="material-symbols-outlined text-[18px]">visibility</span></button></td>
          </tr>
          <tr class="h-[52px] hover:bg-slate-50/60 transition-colors">
            <td class="py-3 px-5 align-middle font-medium text-slate-900">Gudang Surabaya</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">92</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap">3.120 Unit</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap font-medium">Rp 284.700.000</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">19,2%</td>
            <td class="py-3 px-4 align-middle text-center w-14"><button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition-colors" title="Lihat Produk"><span class="material-symbols-outlined text-[18px]">visibility</span></button></td>
          </tr>
          <tr class="h-[52px] hover:bg-slate-50/60 transition-colors">
            <td class="py-3 px-5 align-middle font-medium text-slate-900">Gudang Transit</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">74</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap">2.980 Unit</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap font-medium">Rp 196.500.000</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">13,3%</td>
            <td class="py-3 px-4 align-middle text-center w-14"><button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition-colors" title="Lihat Produk"><span class="material-symbols-outlined text-[18px]">visibility</span></button></td>
          </tr>
          <tr class="h-[52px] hover:bg-slate-50/60 transition-colors">
            <td class="py-3 px-5 align-middle font-medium text-slate-900">Gudang Display</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">58</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap">1.370 Unit</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800 whitespace-nowrap font-medium">Rp 159.000.000</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-800">10,7%</td>
            <td class="py-3 px-4 align-middle text-center w-14"><button type="button" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded transition-colors" title="Lihat Produk"><span class="material-symbols-outlined text-[18px]">visibility</span></button></td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="h-[52px] bg-slate-50 font-bold text-slate-900 border-t-2 border-slate-300">
            <td class="py-3 px-5 align-middle text-slate-900">Total</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-900">392</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-900 whitespace-nowrap">14.820 Unit</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-900 whitespace-nowrap">Rp 1.482.500.000</td>
            <td class="py-3 px-5 align-middle text-right tabular-nums text-slate-900">100%</td>
            <td class="py-3 px-4 align-middle text-center w-14"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>