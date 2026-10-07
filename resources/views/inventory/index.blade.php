@extends('layouts.app')
@section('title', 'Inventory')
@section('page-title', 'Inventory')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Inventory</h2>
      <p class="text-sm text-slate-500 mt-0.5">Pantau stok, reservasi, dan nilai persediaan per gudang</p>
    </div>
    <div class="flex gap-2">
      <button class="h-9 px-4 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">rule</span>
        Opname Stok
      </button>
      <button id="btnAction" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">add</span>
        <span id="btnLabel">Transfer Baru</span>
      </button>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#stok" data-tab="stok" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold">Stok</a>
      <a href="#opname" data-tab="opname" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Opname</a>
      <a href="#transfer" data-tab="transfer" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Transfer Stok</a>
    </nav>
  </div>


  @include('inventory.partials.stock')

  @include('inventory.partials.opname')

  @include('inventory.partials.transfers')
<script>
const tabs = {
  stok: 'Transfer Baru',
  opname: 'Opname Baru',
  transfer: 'Transfer Baru'
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
