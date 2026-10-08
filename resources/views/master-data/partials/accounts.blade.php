  <!-- TAB: COA -->
  <div id="tab-accounts" class="tab-content">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari no akun atau nama akun..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <select class="h-9 px-3 border rounded-lg text-sm">
            <option>Tipe: Semua</option>
            <option>Aset</option>
            <option>Kewajiban</option>
            <option>Ekuitas</option>
            <option>Pendapatan</option>
            <option>HPP</option>
            <option>Beban</option>
          </select>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">10</span> dari <span class="font-medium">10</span> akun</div>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-5 text-left w-32">Kode</th>
            <th class="py-3.5 px-5 text-left">Nama Akun</th>
            <th class="py-3.5 px-5 text-left w-36">Tipe</th>
            <th class="py-3.5 px-5 text-left w-36">Saldo Normal</th>
            <th class="py-3.5 px-5 text-center w-24">Status</th>
            <th class="py-3.5 px-5 text-center w-16">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-5 font-mono text-sm">11100</td>
            <td class="py-3.5 px-5 font-medium">Kas Operasional</td>
            <td class="py-3.5 px-5"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">Aset</span></td>
            <td class="py-3.5 px-5">Debit</td>
            <td class="py-3.5 px-5 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-5 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
