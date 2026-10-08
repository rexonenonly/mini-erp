  <!-- TAB: PARTNER -->
  <div id="tab-partners" class="tab-content">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari kode atau nama mitra..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Tipe: Semua</option>
            <option>Customer</option>
            <option>Supplier</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">5</span> mitra</div>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-5 text-left w-32">Kode</th>
            <th class="py-3.5 px-5 text-left">Nama</th>
            <th class="py-3.5 px-5 text-left w-28">Tipe</th>
            <th class="py-3.5 px-5 text-left w-36">Kontak</th>
            <th class="py-3.5 px-5 text-left w-36">Termin Bayar</th>
            <th class="py-3.5 px-5 text-center w-24">Status</th>
            <th class="py-3.5 px-5 text-center w-16">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-sm">VEND-0124</td>
            <td class="py-3.5 px-5 font-medium">PT Schneider Electric Distribution</td>
            <td class="py-3.5 px-5"><span class="px-2 py-0.5 rounded text-xs bg-blue-50 text-primary border border-blue-100">Supplier</span></td>
            <td class="py-3.5 px-5 font-mono text-sm text-slate-600">021-5551234</td>
            <td class="py-3.5 px-5">30 hari</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
