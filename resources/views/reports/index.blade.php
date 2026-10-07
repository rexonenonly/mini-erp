@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('content')
<div class="space-y-6">
  <!-- 1. PAGE HEADER -->
  <div class="flex flex-col gap-1">
    <h2 class="text-2xl font-semibold">Laporan</h2>
    <p class="text-sm text-slate-500 mt-0.5">Tinjau laporan keuangan dan persediaan</p>
  </div>

  <!-- 2. TABS (Underline style) -->
  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="{{ route('reports.index', ['tab' => 'neraca-saldo']) }}" data-tab="neraca-saldo"
         class="tab-link pb-3 border-b-2 text-sm font-medium {{ request('tab') === 'neraca-saldo' ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
        Neraca Saldo
      </a>
      <a href="{{ route('reports.index', ['tab' => 'laba-rugi']) }}" data-tab="laba-rugi"
         class="tab-link pb-3 border-b-2 text-sm font-medium {{ request('tab') === 'laba-rugi' ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
        Laba Rugi
      </a>
      <a href="{{ route('reports.index', ['tab' => 'umur-piutang-hutang']) }}" data-tab="umur-piutang-hutang"
         class="tab-link pb-3 border-b-2 text-sm font-medium {{ request('tab') === 'umur-piutang-hutang' ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
        Umur Piutang & Hutang
      </a>
      <a href="{{ route('reports.index', ['tab' => 'nilai-persediaan']) }}" data-tab="nilai-persediaan"
         class="tab-link pb-3 border-b-2 text-sm font-medium {{ request('tab') === 'nilai-persediaan' ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">
        Nilai Persediaan
      </a>
    </nav>
  </div>

  @include('reports.partials.trial-balance')
  @include('reports.partials.income-statement')
  @include('reports.partials.aging')
  @include('reports.partials.inventory-valuation')
</div>

<script>
const tabCfg = {
  'neraca-saldo': { label: 'Export Neraca Saldo', icon: 'download' },
  'laba-rugi': { label: 'Export Laba Rugi', icon: 'download' },
  'umur-piutang-hutang': { label: 'Export Aging', icon: 'download' },
  'nilai-persediaan': { label: 'Export Persediaan', icon: 'download' }
};

document.querySelectorAll('.tab-link').forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    const tab = link.dataset.tab;
    document.querySelectorAll('.tab-link').forEach(l => {
      l.classList.remove('border-primary','text-primary','font-semibold');
      l.classList.add('border-transparent','text-slate-500');
    });
    link.classList.remove('border-transparent','text-slate-500');
    link.classList.add('border-primary','text-primary','font-semibold');
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    document.getElementById('btnLabel').textContent = tabCfg[tab].label;
    document.getElementById('btnIcon').textContent = tabCfg[tab].icon;
    history.replaceState(null, '', '?tab=' + tab);
  });
});

// activate initial tab from query string
const h = new URLSearchParams(location.search).get('tab');
if (h && tabCfg[h]) {
  document.querySelector(`[data-tab="${h}"]`).click();
}
</script>
@endsection