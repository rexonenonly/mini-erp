  <!-- TAB: PRODUK -->
  <div id="tab-products" class="tab-content">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari SKU atau nama produk..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Status: Aktif</option>
            <option>Status: Nonaktif</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">8</span> dari <span class="font-medium">348</span> produk</div>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-5 text-left w-40">SKU</th>
            <th class="py-3.5 px-5 text-left">Nama Produk</th>
            <th class="py-3.5 px-5 text-left w-24">Satuan</th>
            <th class="py-3.5 px-5 text-right w-36">Harga Beli</th>
            <th class="py-3.5 px-5 text-right w-36">Harga Jual</th>
            <th class="py-3.5 px-5 text-right w-28">Stok Min</th>
            <th class="py-3.5 px-5 text-center w-28">Status</th>
            <th class="py-3.5 px-5 text-center w-24">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-sm">SKU-ELC-091</td>
            <td class="py-3.5 px-5 font-medium">Kabel NYM 3x2.5mm (100m)</td>
            <td class="py-3.5 px-5 text-slate-600">Roll</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 675.000</td>
            <td class="py-3.5 px-5 text-right font-medium">Rp 760.000</td>
            <td class="py-3.5 px-5 text-right">30</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
