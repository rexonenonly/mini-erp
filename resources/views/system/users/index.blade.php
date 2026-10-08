@extends('layouts.app')
@section('title', 'Pengguna')
@section('content')
<x-ui.page-header title="Pengguna" subtitle="Kelola akun dan role pengguna" />

@if(session('success'))
  <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">{{ $errors->first() }}</div>
@endif

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
  <div class="p-5 border-b border-slate-200 flex flex-wrap justify-between items-center gap-3">
    <form method="GET" action="{{ route('system.users') }}" class="flex flex-wrap gap-3 items-center">
      <div class="relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">search</span>
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email..." class="w-64 h-9 pl-9 pr-3 border border-slate-200 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
      </div>
      <select name="role" onchange="this.form.submit()" class="h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white">
        <option value="">Role: Semua</option>
        @foreach($roles as $r)
          <option value="{{ $r }}" @selected($roleFilter===$r)>{{ $r }}</option>
        @endforeach
      </select>
      <select name="status" onchange="this.form.submit()" class="h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white">
        <option value="">Status: Semua</option>
        <option value="aktif" @selected($statusFilter==='aktif')>Aktif</option>
        <option value="nonaktif" @selected($statusFilter==='nonaktif')>Nonaktif</option>
      </select>
      <button type="submit" class="h-9 px-4 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg">Cari</button>
      @if($q || $roleFilter || $statusFilter)
        <a href="{{ route('system.users') }}" class="h-9 inline-flex items-center px-3 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50">Reset</a>
      @endif
    </form>
    <div class="text-sm text-slate-500 whitespace-nowrap">Menampilkan <span class="font-medium text-slate-900">{{ $users->count() }}</span> dari <span class="font-medium text-slate-900">{{ $total }}</span> pengguna</div>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
        <tr>
          <th class="py-3.5 px-5 text-left">Pengguna</th>
          <th class="py-3.5 px-5 text-left w-40">Role</th>
          <th class="py-3.5 px-5 text-center w-28">Status</th>
          <th class="py-3.5 px-5 text-left w-44 whitespace-nowrap">Terakhir Login</th>
          <th class="py-3.5 px-5 text-center w-14">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200">
        @forelse($users as $u)
          @php
            $initials = collect(explode(' ', $u->name))->map(fn($p)=>mb_strtoupper(mb_substr($p,0,1)))->take(2)->implode('');
            $roleName = $u->getRoleNames()->first() ?? '-';
          @endphp
          <tr class="h-[52px] hover:bg-slate-50">
            <td class="px-5 py-3.5">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center font-semibold text-slate-700 text-xs select-none shrink-0">{{ $initials }}</div>
                <div class="min-w-0">
                  <div class="font-medium text-slate-900 truncate">{{ $u->name }}</div>
                  <div class="text-xs text-slate-500 truncate">{{ $u->email }}</div>
                </div>
              </div>
            </td>
            <td class="px-5 py-3.5"><span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-700 border border-slate-200">{{ $roleName }}</span></td>
            <td class="px-5 py-3.5 text-center">
              @if($u->is_active)
                <span class="inline-flex px-2 py-0.5 rounded text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
              @else
                <span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-100 text-slate-600 border border-slate-200">Nonaktif</span>
              @endif
            </td>
            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600 text-xs">
              @if($u->last_login_at)
                {{ $u->last_login_at->locale('id')->translatedFormat('d M Y H:i') }}
              @else
                <span class="text-slate-400">Belum pernah</span>
              @endif
            </td>
            <td class="px-5 py-3.5 text-center">
              <a href="{{ route('system.users.edit', $u) }}" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary rounded hover:bg-slate-100" title="Ubah"><span class="material-symbols-outlined text-lg">edit</span></a>
            </td>
          </tr>
        @empty
          <tr class="h-[52px]"><td colspan="5" class="px-5 py-8 text-center text-slate-500">Tidak ada pengguna.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($users->hasPages())
    <div class="p-4 border-t border-slate-200">{{ $users->links() }}</div>
  @endif
</div>
@endsection
