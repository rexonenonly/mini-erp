  <!-- TAB: PEMBAYARAN -->
  <div id="tab-payments" class="tab-content">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor pembayaran atau bill..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Metode: Semua</option>
            <option>Transfer Bank</option>
            <option>Tunai</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Diposting</option>
            <option>Dibalik</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">14</span> pembayaran</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm purchasing-table">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-44">No. Pembayaran</th>
              <th class="py-3.5 px-4 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-4 text-left w-40">No. Bill</th>
              <th class="py-3.5 px-4 text-left">Supplier</th>
              <th class="py-3.5 px-4 text-left w-32">Metode</th>
              <th class="py-3.5 px-4 text-right w-32">Jumlah</th>
              <th class="py-3.5 px-4 text-center w-24">Status</th>
              <th class="py-3.5 px-4 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-4 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0010</td>
              <td class="py-3.5 px-4 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0017</td>
              <td class="py-3.5 px-4 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 6.000.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0009</td>
              <td class="py-3.5 px-4 text-slate-600">09 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0016</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 12.000.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0008</td>
              <td class="py-3.5 px-4 text-slate-600">04 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0016</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 15.000.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0007</td>
              <td class="py-3.5 px-4 text-slate-600">03 Okt 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0015</td>
              <td class="py-3.5 px-4 font-medium">PT Schneider Electric Distribution</td>
              <td class="py-3.5 px-4 text-slate-600">Tunai</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 8.240.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Diposting</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">PV-2026-10-0006</td>
              <td class="py-3.5 px-4 text-slate-600">27 Sep 2026</td>
              <td class="py-3.5 px-4 font-mono text-xs text-primary">VB-2026-10-0014</td>
              <td class="py-3.5 px-4 font-medium">PT Tembaga Nusantara</td>
              <td class="py-3.5 px-4 text-slate-600">Transfer Bank</td>
              <td class="py-3.5 px-4 text-right font-medium">Rp 15.300.000</td>
              <td class="py-3.5 px-4 text-center"><span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-rose-50 text-rose-700 border border-rose-200"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Dibalik</span></td>
              <td class="py-3.5 px-4 text-slate-600">Budi</td>
              <td class="py-3.5 px-4 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 3</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
