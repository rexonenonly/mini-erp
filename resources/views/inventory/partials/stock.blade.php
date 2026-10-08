<div class="space-y-4">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border rounded-lg p-4">
      <div class="text-xs font-medium uppercase text-slate-500">Total Fisik (On Hand)</div>
      <div class="text-2xl font-semibold mt-2 text-slate-900">14.820 Unit</div>
      <div class="text-xs text-slate-500 mt-1">Di 4 gudang</div>
    </div>
    <div class="bg-white border rounded-lg p-4">
      <div class="text-xs font-medium uppercase text-slate-500">Direservasi</div>
      <div class="text-2xl font-semibold mt-2 text-slate-900">2.150 Unit</div>
      <div class="text-xs text-slate-500 mt-1">14 sales order aktif</div>
    </div>
    <div class="bg-white border rounded-lg p-4">
      <div class="text-xs font-medium uppercase text-slate-500">Siap Jual (Available)</div>
      <div class="text-2xl font-semibold mt-2 text-slate-900">12.670 Unit</div>
      <div class="text-xs text-slate-500 mt-1">On hand dikurangi reserved</div>
    </div>
    <div class="bg-white border rounded-lg p-4">
      <div class="text-xs font-medium uppercase text-slate-500">Nilai Persediaan</div>
      <div class="text-2xl font-semibold mt-2 text-slate-900">Rp 1.482.500.000</div>
      <div class="text-xs text-slate-500 mt-1">Metode rata-rata bergerak</div>
    </div>
  </div>

  <div class="bg-white border rounded-lg">
    <div class="p-5 border-b flex justify-between items-center">
      <div class="flex gap-3">
        <input type="text" placeholder="Cari SKU atau nama produk..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
        <select class="h-9 px-3 border rounded-lg text-sm">
          <option>Gudang: Semua</option>
          <option>Gudang Utama</option>
          <option>Gudang Display</option>
          <option>Gudang Surabaya</option>
          <option>Gudang Transit</option>
        </select>
        <select class="h-9 px-3 border rounded-lg text-sm">
          <option>Status: Semua</option>
          <option>Tersedia</option>
          <option>Menipis</option>
          <option>Kritis</option>
        </select>
      </div>
      <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">392</span> baris stok</div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-5 text-left w-32">SKU</th>
            <th class="py-3.5 px-5 text-left">Nama Produk</th>
            <th class="py-3.5 px-5 text-left w-32">Gudang</th>
            <th class="py-3.5 px-5 text-right w-24">On Hand</th>
            <th class="py-3.5 px-5 text-right w-24">Reserved</th>
            <th class="py-3.5 px-5 text-right w-24">Available</th>
            <th class="py-3.5 px-5 text-right w-28">Rata-Rata</th>
            <th class="py-3.5 px-5 text-right w-32">Nilai</th>
            <th class="py-3.5 px-5 text-center w-24">Status</th>
            <th class="py-3.5 px-5 text-center w-16">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-xs">SKU-ELC-091</td>
            <td class="py-3.5 px-5 font-medium">Kabel NYM 3x2.5mm (100m)</td>
            <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
            <td class="py-3.5 px-5 text-right font-medium">150 Roll</td>
            <td class="py-3.5 px-5 text-right">40 Roll</td>
            <td class="py-3.5 px-5 text-right font-medium">110 Roll</td>
            <td class="py-3.5 px-5 text-right">Rp 678.529</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 101.779.350</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Tersedia</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-xs">SKU-ELC-003</td>
            <td class="py-3.5 px-5 font-medium">MCB 1P 16A Schneider</td>
            <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
            <td class="py-3.5 px-5 text-right font-medium">12 Pcs</td>
            <td class="py-3.5 px-5 text-right">10 Pcs</td>
            <td class="py-3.5 px-5 text-right font-medium">2 Pcs</td>
            <td class="py-3.5 px-5 text-right">Rp 51.500</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 618.000</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-red-50 text-red-700 border border-red-200">Kritis</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-xs">SKU-MEC-014</td>
            <td class="py-3.5 px-5 font-medium">Bearing Ball Industrial 6205</td>
            <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
            <td class="py-3.5 px-5 text-right font-medium">35 Pcs</td>
            <td class="py-3.5 px-5 text-right">27 Pcs</td>
            <td class="py-3.5 px-5 text-right font-medium">8 Pcs</td>
            <td class="py-3.5 px-5 text-right">Rp 145.000</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 5.075.000</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Menipis</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-xs">SKU-LUB-082</td>
            <td class="py-3.5 px-5 font-medium">Oli Pelumas Industri ISO-VG46</td>
            <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
            <td class="py-3.5 px-5 text-right font-medium">24 Pail</td>
            <td class="py-3.5 px-5 text-right">15 Pail</td>
            <td class="py-3.5 px-5 text-right font-medium">9 Pail</td>
            <td class="py-3.5 px-5 text-right">Rp 1.150.000</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 27.600.000</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Menipis</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
          </tr>
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-xs">SKU-BLD-002</td>
            <td class="py-3.5 px-5 font-medium">Semen Mortar Skimcoat 40kg</td>
            <td class="py-3.5 px-5 text-slate-600">Gudang Transit</td>
            <td class="py-3.5 px-5 text-right font-medium">620 Sak</td>
            <td class="py-3.5 px-5 text-right">0 Sak</td>
            <td class="py-3.5 px-5 text-right font-medium">620 Sak</td>
            <td class="py-3.5 px-5 text-right">Rp 78.500</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 48.670.000</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Tersedia</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">receipt_long</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
      <div class="text-sm text-slate-500">Halaman 1 dari 79</div>
      <div class="flex items-center gap-1">
        <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
        <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
        <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
        <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">79</button>
        <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
      </div>
    </div>
  </div>
</div>
