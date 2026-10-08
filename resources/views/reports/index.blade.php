@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('content')
@php
$tab = request('tab', 'trial-balance');
$allowed = ['trial-balance', 'income-statement', 'aging', 'inventory-valuation'];
if (!in_array($tab, $allowed)) { $tab = 'trial-balance'; }
$tabConfig = [
    'trial-balance'      => ['label' => 'Neraca Saldo', 'partial' => 'reports.partials.trial-balance'],
    'income-statement'   => ['label' => 'Laba Rugi',     'partial' => 'reports.partials.income-statement'],
    'aging'              => ['label' => 'Umur Piutang & Hutang', 'partial' => 'reports.partials.aging'],
    'inventory-valuation' => ['label' => 'Nilai Persediaan', 'partial' => 'reports.partials.inventory-valuation'],
];
@endphp

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="2xl font-semibold hidden">Laporan</h2>
    </div>
  </div>

  <div class="border-b">
    <nav class="flex gap-8 -mb-px">
      @foreach($tabConfig as $slug => $cfg)
      <a href="{{ route('reports.index', ['tab' => $slug]) }}" class="pb-3 border-b-2 text-sm font-medium {{ $tab === $slug ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">{{ $cfg['label'] }}</a>
      @endforeach
    </nav>
  </div>

  @include($tabConfig[$tab]['partial'])
</div>
@endsection
