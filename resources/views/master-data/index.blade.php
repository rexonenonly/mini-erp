@extends('layouts.app')
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

  @include('master-data.partials.products')
  @include('master-data.partials.warehouses')
  @include('master-data.partials.partners')
  @include('master-data.partials.accounts')
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
