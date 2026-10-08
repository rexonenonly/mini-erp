@extends('layouts.app')
@section('title', 'Inventory')
@section('page-title', 'Inventory')
@section('content')
@php
$tab = request('tab', 'stock');
$allowed = ['stock', 'opname', 'transfers'];
if (!in_array($tab, $allowed)) { $tab = 'stock'; }
$tabConfig = [
    'stock'     => ['label' => 'Stok',          'btn' => null,              'icon' => null],
    'opname'    => ['label' => 'Opname',         'btn' => 'Opname Baru',      'icon' => 'add'],
    'transfers' => ['label' => 'Transfer Stok', 'btn' => 'Transfer Baru',   'icon' => 'add'],
];
@endphp

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Inventory</h2>
      <p class="text-sm text-slate-500 mt-0.5">Pantau stok, reservasi, dan nilai persediaan per gudang</p>
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

  @if($tab === 'stock')
    @include('inventory.partials.stock')
  @elseif($tab === 'opname')
    @include('inventory.partials.opname')
  @elseif($tab === 'transfers')
    @include('inventory.partials.transfers')
  @endif
</div>
@endsection
