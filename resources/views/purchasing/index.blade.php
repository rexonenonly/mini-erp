@extends('layouts.app')
@section('title', 'Purchasing')
@section('page-title', 'Purchasing')
@section('content')
@php
$tab = request('tab', 'orders');
$allowed = ['orders', 'receipts', 'bills', 'payments'];
if (!in_array($tab, $allowed)) { $tab = 'orders'; }
$tabConfig = [
    'orders'   => ['label' => 'Pesanan',    'btn' => 'Buat Pesanan',   'icon' => 'add'],
    'receipts' => ['label' => 'Penerimaan',  'btn' => 'Terima Barang',   'icon' => 'inventory'],
    'bills'    => ['label' => 'Tagihan',     'btn' => 'Input Tagihan',   'icon' => 'receipt_long'],
    'payments' => ['label' => 'Pembayaran',  'btn' => 'Bayar Tagihan',   'icon' => 'payments'],
];
@endphp

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-semibold">Purchasing</h2>
      <p class="text-sm text-slate-500 mt-0.5">Kelola pesanan, penerimaan, tagihan, dan pembayaran ke supplier</p>
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

  @if($tab === 'orders')
    @include('purchasing.partials.orders')
  @elseif($tab === 'receipts')
    @include('purchasing.partials.receipts')
  @elseif($tab === 'bills')
    @include('purchasing.partials.bills')
  @elseif($tab === 'payments')
    @include('purchasing.partials.payments')
  @endif
</div>
@endsection
