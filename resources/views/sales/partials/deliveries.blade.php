{{-- Deliveries --}}
<div id="tab-deliveries" class="tab-content {{ request('tab') !== 'deliveries' ? 'hidden' : '' }} space-y-4">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari nomor pengiriman atau SO..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
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
            <option>Gudang Transit</option>
            <option>Gudang Surabaya</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">27</span> pengiriman</div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
            <tr>
              <th class="py-3.5 px-5 text-left w-40">No. Pengiriman</th>
              <th class="py-3.5 px-5 text-left w-28">Tanggal</th>
              <th class="py-3.5 px-5 text-left w-40">No. SO</th>
              <th class="py-3.5 px-5 text-left">Customer</th>
              <th class="py-3.5 px-5 text-left w-32">Gudang</th>
              <th class="py-3.5 px-5 text-right w-24">Jumlah Item</th>
              <th class="py-3.5 px-5 text-right w-32">Nilai HPP</th>
              <th class="py-3.5 px-5 text-left w-40">Invoice</th>
              <th class="py-3.5 px-5 text-center w-28">Status</th>
              <th class="py-3.5 px-5 text-center w-16">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0082</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0089</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">-</td>
              <td class="py-3.5 px-5 text-slate-400">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Draft</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0081</td>
              <td class="py-3.5 px-5 text-slate-600">14 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0074</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 13.570.580</td>
              <td class="py-3.5 px-5 text-slate-500">Belum ditagih</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0080</td>
              <td class="py-3.5 px-5 text-slate-600">13 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0084</td>
              <td class="py-3.5 px-5 font-medium">Toko Sinar Teknik</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Display</td>
              <td class="py-3.5 px-5 text-right">2 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.220.000</td>
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0055</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0079</td>
              <td class="py-3.5 px-5 text-slate-600">12 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0088</td>
              <td class="py-3.5 px-5 font-medium">PT Mega Konstruksi</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Utama</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 1.885.000</td>
              <td class="py-3.5 px-5 font-mono text-xs">INV-2026-10-0056</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Diposting</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
            <tr class="hover:bg-slate-50">
              <td class="py-3.5 px-5 font-mono text-xs">DO-2026-10-0078</td>
              <td class="py-3.5 px-5 text-slate-600">09 Okt 2026</td>
              <td class="py-3.5 px-5 font-mono text-xs">SO-2026-10-0081</td>
              <td class="py-3.5 px-5 font-medium">CV Citra Bangun Mandiri</td>
              <td class="py-3.5 px-5 text-slate-600">Gudang Transit</td>
              <td class="py-3.5 px-5 text-right">1 item</td>
              <td class="py-3.5 px-5 text-right font-medium">Rp 3.925.000</td>
              <td class="py-3.5 px-5 text-slate-400">-</td>
              <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-amber-50 text-amber-700 border border-amber-200">Dibalik</span></td>
              <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">visibility</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-4 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-sm text-slate-500">Halaman 1 dari 6</div>
        <div class="flex items-center gap-1">
          <button class="h-8 px-3 text-slate-400 cursor-not-allowed text-sm" disabled>Sebelumnya</button>
          <button class="w-8 h-8 bg-primary text-white text-sm font-medium flex items-center justify-center">1</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">2</button>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">3</button>
          <span class="w-8 h-8 flex items-center justify-center text-slate-400">...</span>
          <button class="w-8 h-8 text-slate-500 hover:bg-slate-50 text-sm">6</button>
          <button class="h-8 px-3 text-slate-500 hover:bg-slate-50 text-sm">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
