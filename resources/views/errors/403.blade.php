@if(auth()->check())
@extends('layouts.app')
@section('title', 'Akses Ditolak')
@section('content')
<div class="flex flex-col items-center justify-center py-16 text-center">
  <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center mb-4">
    <span class="material-symbols-outlined text-3xl text-amber-600">block</span>
  </div>
  <h1 class="text-xl font-semibold text-slate-900">Akses Ditolak</h1>
  <p class="text-sm text-slate-500 mt-2 max-w-md">Anda tidak memiliki akses ke halaman ini. Hubungi administrator jika Anda merasa ini kesalahan.</p>
  <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center gap-1.5 h-9 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
    <span class="material-symbols-outlined text-lg">arrow_back</span>
    <span>Kembali ke Dashboard</span>
  </a>
</div>
@endsection
@else
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Akses Ditolak</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="min-h-screen flex items-center justify-center bg-slate-50 p-6" style="font-family:Inter,sans-serif">
<div class="text-center max-w-md">
  <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center mx-auto mb-4">
    <span class="material-symbols-outlined text-3xl text-amber-600">block</span>
  </div>
  <h1 class="text-xl font-semibold text-slate-900">Akses Ditolak</h1>
  <p class="text-sm text-slate-500 mt-2">Anda tidak memiliki akses ke halaman ini. Silakan masuk terlebih dahulu.</p>
  <a href="{{ route('login') }}" class="mt-6 inline-flex items-center gap-1.5 h-9 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg shadow-sm">Masuk</a>
</div>
</body></html>
@endif
