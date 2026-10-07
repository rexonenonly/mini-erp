@extends('layouts.app')
@section('title', 'Accounting')
@section('page-title', 'Accounting')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Accounting</h2>
      <p class="text-sm text-slate-500 mt-0.5">Catat dan tinjau jurnal, buku besar, dan periode akuntansi</p>
    </div>
    <div class="flex gap-2">
      <button id="btnAction" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span id="btnIcon" class="material-symbols-outlined text-lg">add</span>
        <span id="btnLabel">Jurnal Manual Baru</span>
      </button>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      <a href="#jurnal" data-tab="jurnal" class="tab-link pb-3 border-b-2 border-primary text-primary font-semibold">Jurnal Umum</a>
      <a href="#buku-besar" data-tab="buku-besar" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Buku Besar</a>
      <a href="#periode" data-tab="periode" class="tab-link pb-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900">Periode</a>
    </nav>
  </div>


  @include('accounting.partials.journals')

  @include('accounting.partials.ledger')

  @include('accounting.partials.periods')

<script>
const btnCfg = {
  jurnal: { label: 'Jurnal Manual Baru', icon: 'add' },
  'buku-besar': { label: 'Export Buku Besar', icon: 'download' },
  periode: { label: 'Tutup Periode', icon: 'lock' }
};
document.querySelectorAll('.tab-link').forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    const tab = link.dataset.tab;
    document.querySelectorAll('.tab-link').forEach(l => { l.classList.remove('border-primary','text-primary','font-semibold'); l.classList.add('border-transparent','text-slate-500'); });
    link.classList.remove('border-transparent','text-slate-500');
    link.classList.add('border-primary','text-primary','font-semibold');
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    document.getElementById('btnLabel').textContent = btnCfg[tab].label;
    document.getElementById('btnIcon').textContent = btnCfg[tab].icon;
    history.replaceState(null, '', '#' + tab);
  });
});
const h = location.hash.slice(1);
if (h && btnCfg[h]) document.querySelector(`[data-tab="${h}"]`).click();
// expand jurnal detail
document.querySelectorAll('.expand-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const row = document.getElementById(btn.dataset.target);
    if (row) { row.classList.toggle('hidden'); btn.querySelector('.material-symbols-outlined').textContent = row.classList.contains('hidden') ? 'chevron_right' : 'expand_more'; }
  });
});
</script>
@endsection
