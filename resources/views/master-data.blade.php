@extends('layouts.dashboard')
@section('title', 'Master Data')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Master Data</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola produk, gudang, partner, dan akun</p>
    </div>
    <button id="btnAction" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
      <span class="material-symbols-outlined text-lg">add</span>
      <span id="btnLabel">Produk Baru</span>
    </button>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#products" data-tab="products" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold flex items-center gap-2">
        <span>Produk</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-50 text-primary border border-blue-100">348</span>
      </a>
      <a href="#warehouses" data-tab="warehouses" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Gudang</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">4</span>
      </a>
      <a href="#partners" data-tab="partners" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Partner</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">5</span>
      </a>
      <a href="#accounts" data-tab="accounts" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Chart of Accounts</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">10</span>
      </a>
    </nav>
  </div>

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
            <td class="py-3.5 px-5 text-center"><button class="text-primary hover:text-primary-hover text-sm font-medium">Ubah</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- TAB: GUDANG -->
  <div id="tab-warehouses" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <input type="text" placeholder="Cari kode atau nama gudang..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">4</span> dari <span class="font-medium">4</span> gudang</div>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-3 text-left w-40">Kode</th>
            <th class="py-3.5 px-3 text-left">Nama Gudang</th>
            <th class="py-3.5 px-3 text-left">Alamat</th>
            <th class="py-3.5 px-3 text-center w-28">Status</th>
            <th class="py-3.5 px-3 text-center w-20">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-3 font-mono">WH-UTM</td>
            <td class="py-3.5 px-3 font-medium">Gudang Utama</td>
            <td class="py-3.5 px-3 text-slate-600">Cikupa, Tangerang</td>
            <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- TAB: PARTNER -->
  <div id="tab-partners" class="tab-content hidden">
    <div class="bg-white border rounded-lg">
      <div class="p-5 border-b flex justify-between items-center">
        <div class="flex gap-3">
          <input type="text" placeholder="Cari kode atau nama partner..." class="w-72 h-9 pl-3 border rounded-lg text-sm">
          <div class="inline-flex rounded-lg border p-0.5 bg-slate-50">
            <button class="px-3 py-1 rounded text-xs font-medium bg-white shadow-sm border">Semua</button>
            <button class="px-3 py-1 rounded text-xs font-medium text-slate-600 hover:text-slate-900">Customer</button>
            <button class="px-3 py-1 rounded text-xs font-medium text-slate-600 hover:text-slate-900">Supplier</button>
          </div>
        </div>
        <div class="text-sm text-slate-500">Menampilkan <span class="font-medium text-slate-900">5</span> dari <span class="font-medium">5</span> partner</div>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b text-xs uppercase text-slate-500">
          <tr>
            <th class="py-3.5 px-3 text-left w-32">Kode</th>
            <th class="py-3.5 px-3 text-left">Nama</th>
            <th class="py-3.5 px-3 text-left w-28">Tipe</th>
            <th class="py-3.5 px-3 text-left w-36">Kontak</th>
            <th class="py-3.5 px-3 text-left w-36">Termin Bayar</th>
            <th class="py-3.5 px-3 text-center w-24">Status</th>
            <th class="py-3.5 px-3 text-center w-16">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-3 font-mono text-sm">VEND-0124</td>
            <td class="py-3.5 px-3 font-medium">PT Schneider Electric Distribution</td>
            <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-blue-50 text-primary border border-blue-100">Supplier</span></td>
            <td class="py-3.5 px-3 font-mono text-sm text-slate-600">021-5551234</td>
            <td class="py-3.5 px-3">30 hari</td>
            <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- TAB: COA -->
  <div id="tab-accounts" class="tab-content hidden">
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
            <th class="py-3.5 px-3 text-left w-32">Kode</th>
            <th class="py-3.5 px-3 text-left">Nama Akun</th>
            <th class="py-3.5 px-3 text-left w-36">Tipe</th>
            <th class="py-3.5 px-3 text-left w-36">Saldo Normal</th>
            <th class="py-3.5 px-3 text-center w-24">Status</th>
            <th class="py-3.5 px-3 text-center w-16">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr class="hover:bg-slate-50">
            <td class="py-3.5 px-3 font-mono text-sm">11100</td>
            <td class="py-3.5 px-3 font-medium">Kas Operasional</td>
            <td class="py-3.5 px-3"><span class="px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">Aset</span></td>
            <td class="py-3.5 px-3">Debit</td>
            <td class="py-3.5 px-3 text-center"><span class="px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span></td>
            <td class="py-3.5 px-3 text-center"><button class="w-8 h-8 text-slate-500 hover:text-primary"><span class="material-symbols-outlined text-lg">edit</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
const tabs = {
  products: 'Produk Baru',
  warehouses: 'Gudang Baru',
  partners: 'Partner Baru',
  accounts: 'Akun Baru'
};

document.querySelectorAll('.tab-link').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const tab = link.dataset.tab;
    
    document.querySelectorAll('.tab-link').forEach(l => {
      l.classList.remove('border-primary', 'text-primary', 'font-semibold');
      l.classList.add('border-transparent', 'text-slate-500');
    });
    link.classList.remove('border-transparent', 'text-slate-500');
    link.classList.add('border-primary', 'text-primary', 'font-semibold');
    
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    
    document.getElementById('btnLabel').textContent = tabs[tab];
    history.replaceState(null, '', '#' + tab);
  });
});

// ponytail: init dari hash jika ada
const hash = location.hash.slice(1);
if (hash && tabs[hash]) {
  document.querySelector(`[data-tab="${hash}"]`).click();
}
</script>
@endsection
