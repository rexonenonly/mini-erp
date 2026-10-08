@extends('layouts.app')
@section('title', 'Purchasing')
@section('page-title', 'Purchasing')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Purchasing</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola pembelian dari pemesanan sampai pembayaran ke supplier</p>
    </div>
    <div class="flex gap-2">
      <button class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">add</span>
        <span id="btnLabel">Purchase Order Baru</span>
      </button>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#po" data-tab="po" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold">Purchase Order</a>
      <a href="#penerimaan" data-tab="penerimaan" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Penerimaan</a>
      <a href="#vendor-bill" data-tab="vendor-bill" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Tagihan</a>
      <a href="#pembayaran" data-tab="pembayaran" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Pembayaran</a>
    </nav>
  </div>

  @include('purchasing.partials.orders')
  @include('purchasing.partials.receipts')
  @include('purchasing.partials.bills')
  @include('purchasing.partials.payments')
</div>

<script>
const tabs = {
  'po': 'Purchase Order Baru',
  'penerimaan': 'Penerimaan Baru',
  'vendor-bill': 'Tagihan Baru',
  'pembayaran': 'Pembayaran Baru'
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
