@extends('layouts.app')
@section('title', 'Accounting')
@section('page-title', 'Accounting')
@section('content')
@php
$tab = request('tab', 'journals');
$allowed = ['journals', 'ledger', 'periods'];
if (!in_array($tab, $allowed)) { $tab = 'journals'; }
$tabConfig = [
    'journals' => ['label' => 'Jurnal Umum', 'btn' => 'Jurnal Manual Baru', 'icon' => 'add'],
    'ledger'   => ['label' => 'Buku Besar',  'btn' => null,                 'icon' => null],
    'periods'  => ['label' => 'Periode',      'btn' => 'Tutup Periode',      'icon' => 'lock'],
];
@endphp

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Accounting</h2>
      <p class="text-sm text-slate-500 mt-0.5">Catat dan tinjau jurnal, buku besar, dan periode akuntansi</p>
    </div>
    @if($tabConfig[$tab]['btn'])
    <div class="flex gap-2">
      <a href="#" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">{{ $tabConfig[$tab]['icon'] }}</span>
        <span>{{ $tabConfig[$tab]['btn'] }}</span>
      </a>
    </div>
    @endif
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      @foreach($tabConfig as $slug => $cfg)
      <a href="?tab={{ $slug }}" class="pb-3 border-b-2 {{ $tab === $slug ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">{{ $cfg['label'] }}</a>
      @endforeach
    </nav>
  </div>

  @if($tab === 'journals')
    @include('accounting.partials.journals')
  @elseif($tab === 'ledger')
    @include('accounting.partials.ledger')
  @elseif($tab === 'periods')
    @include('accounting.partials.periods')
  @endif
</div>
@endsection
