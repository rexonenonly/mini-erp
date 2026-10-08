@extends('layouts.app')
@section('title', $isEdit ? 'Ubah Pengguna' : 'Pengguna Baru')
@section('content')
<x-ui.page-header :title="$isEdit ? 'Ubah Pengguna' : 'Pengguna Baru'" :subtitle="$isEdit ? 'Perbarui data pengguna' : 'Tambah pengguna baru'" :breadcrumb="$isEdit ? 'Sistem / Pengguna / Ubah' : 'Sistem / Pengguna / Baru'" />

@if($errors->any())
  <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
    <ul class="list-disc list-inside space-y-0.5">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
@endif

<div class="max-w-2xl">
  <form method="POST" action="{{ $isEdit ? route('system.users.update', $user) : route('system.users.store') }}" class="bg-white border border-slate-200 rounded-lg p-6 space-y-5">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div>
      <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama <span class="text-red-500">*</span></label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Nama lengkap">
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Email <span class="text-red-500">*</span></label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="nama@minierp.test">
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Role <span class="text-red-500">*</span></label>
      <select name="role" required class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
        <option value="">-- Pilih Role --</option>
        @foreach($roles as $r)
          <option value="{{ $r->name }}" @selected(old('role', $user->getRoleNames()->first())===$r->name)>{{ $r->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi @if(!$isEdit)<span class="text-red-500">*</span>@endif</label>
      <input type="password" name="password" @if(!$isEdit) required @endif class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="{{ $isEdit ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}">
      @if($isEdit)<p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak diubah</p>@endif
    </div>

    <div>
      <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi @if(!$isEdit)<span class="text-red-500">*</span>@endif</label>
      <input type="password" name="password_confirmation" @if(!$isEdit) required @endif class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Ulangi kata sandi">
    </div>

    <div class="flex items-center gap-3 pt-1">
      <label class="flex items-center gap-2 cursor-pointer select-none">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active ?? true)) class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary">
        <span class="text-sm text-slate-700">Aktif</span>
      </label>
    </div>

    <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
      <button type="submit" class="h-9 px-5 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg shadow-sm transition-colors">Simpan</button>
      <a href="{{ route('system.users') }}" class="h-9 inline-flex items-center px-5 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Batal</a>
    </div>
  </form>

  @if($isEdit)
    <div class="mt-6 bg-white border border-slate-200 rounded-lg p-5">
      <h3 class="text-sm font-semibold text-slate-900">Status Akun</h3>
      <p class="text-xs text-slate-500 mt-1">
        @if($user->is_active) Akun aktif. Nonaktifkan untuk mencegah login.
        @else Akun nonaktif. Aktifkan kembali untuk mengizinkan login. @endif
      </p>
      <form method="POST" action="{{ route('system.users.status', $user) }}" class="mt-3" onsubmit="return confirm('{{ $user->is_active ? 'Nonaktifkan pengguna ini?' : 'Aktifkan pengguna ini?' }}')">
        @csrf @method('PATCH')
        <button type="submit" class="h-9 px-4 rounded-lg text-sm font-medium border {{ $user->is_active ? 'bg-white border-amber-300 text-amber-700 hover:bg-amber-50' : 'bg-emerald-600 hover:bg-emerald-700 text-white border-emerald-600' }}">
          {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
        </button>
      </form>
    </div>
  @endif
</div>
@endsection
