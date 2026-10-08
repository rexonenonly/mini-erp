{{-- Sales Orders --}}
<div id="tab-orders" class="tab-content" space-y-4">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor SO atau customer..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Status: Semua</option>
            <option>Draft</option>
            <option>Dikonfirmasi</option>
            <option>Parsial</option>
            <option>Selesai</option>
            <option>Dibatalkan</option>
          </select>
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Customer: Semua</option>
            <option>Toko Sinar Teknik</option>
            <option>CV Citra Bangun Mandiri</option>
            <option>PT Mega Konstruksi</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">31</span> SO</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. SO</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang Asal</th>
              <th class="py-3.5 px-5 text-right w-32">Total</th>
              <th class="py-3.5 px-5 text-center w-32">Status</th>
              <th class="py-3.5 px-5 text-left w-28">Dibuat Oleh</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0090</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.100.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0089</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 30.400.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs border border-slate-400 text-slate-700">Dikonfirmasi</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0088</td>
              <td class="py-3.5 px-5 text-slate-600">12 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 7.120.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Parsial</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0087</td>
              <td class="py-3.5 px-5 text-slate-600">11 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Surabaya</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 19.800.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs border border-slate-400 text-slate-700">Dikonfirmasi</span></td>
              <td class="py-3.5 px-5">Rina</td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0074</td>
              <td class="py-3.5 px-5 text-slate-600">08 Okt 2026</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 15.200.000</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai</span></td>
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
