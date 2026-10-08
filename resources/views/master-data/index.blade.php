@extends('layouts.app')
@section('title', 'Master Data')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Master Data</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola produk, gudang, mitra, dan akun</p>
    </div>
    <button id="btnAction" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
      <span class="material-symbols-outlined text-lg">add</span>
      <span id="btnLabel">Produk Baru</span>
    </button>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="?tab=products" data-tab="products" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold flex items-center gap-2">
        <span>Produk</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-50 text-primary border border-blue-100">348</span>
      </a>
      <a href="?tab=warehouses" data-tab="warehouses" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Gudang</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">4</span>
      </a>
      <a href="?tab=partners" data-tab="partners" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
        <span>Mitra</span>
        <span class="text-xs px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-600">5</span>
      </a>
      <a href="?tab=accounts" data-tab="accounts" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2">
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
  partners: 'Mitra Baru',
  accounts: 'Akun Baru'
};
const allowlist = ['products', 'warehouses', 'partners', 'accounts'];
const defaultTab = 'products';

function getActiveTab() {
  const params = new URLSearchParams(window.location.search);
  const tab = params.get('tab');
  return allowlist.includes(tab) ? tab : defaultTab;
}

function activateTab(tab) {
  document.querySelectorAll('.tab-link').forEach(l => {
    l.classList.remove('border-primary', 'text-primary', 'font-semibold');
    l.classList.add('border-transparent', 'text-slate-500');
  });
  const link = document.querySelector(`[data-tab="${tab}"]`);
  if (link) {
    link.classList.remove('border-transparent', 'text-slate-500');
    link.classList.add('border-primary', 'text-primary', 'font-semibold');
  }

  document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
  const content = document.getElementById('tab-' + tab);
  if (content) content.classList.remove('hidden');

  document.getElementById('btnLabel').textContent = tabs[tab] || tabs[defaultTab];
}

document.querySelectorAll('.tab-link').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const tab = link.dataset.tab;
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    history.pushState(null, '', url);
    activateTab(tab);
  });
});

window.addEventListener('popstate', () => {
  activateTab(getActiveTab());
});

activateTab(getActiveTab());
</script>
@endsection
