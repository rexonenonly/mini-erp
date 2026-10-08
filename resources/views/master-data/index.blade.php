@extends('layouts.app')
@section('title', 'Master Data')
@section('page-title', 'Master Data')
@section('content')
@php
$tab = request('tab', 'products');
$allowed = ['products', 'warehouses', 'partners', 'accounts'];
if (!in_array($tab, $allowed)) { $tab = 'products'; }
$tabConfig = [
    'products'   => ['label' => 'Produk',   'btn' => 'Produk Baru',      'icon' => 'add'],
    'warehouses' => ['label' => 'Gudang',    'btn' => 'Gudang Baru',      'icon' => 'add'],
    'partners'   => ['label' => 'Partner',   'btn' => 'Partner Baru',     'icon' => 'add'],
    'accounts'   => ['label' => 'Akun',      'btn' => 'Akun Baru',        'icon' => 'add'],
];
@endphp

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Master Data</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola produk, gudang, partner, dan akun COA</p>
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

  @if($tab === 'products')
    @include('master-data.partials.products')
  @elseif($tab === 'warehouses')
    @include('master-data.partials.warehouses')
  @elseif($tab === 'partners')
    @include('master-data.partials.partners')
  @elseif($tab === 'accounts')
    @include('master-data.partials.accounts')
  @endif
</div>
@endsection
