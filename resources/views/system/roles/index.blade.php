@extends('layouts.app')
@section('title', 'Role & Izin')
@section('content')
<x-ui.page-header title="Role & Izin" subtitle="Atur hak akses setiap role" />

@if(session('success'))
  <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">{{ $errors->first() }}</div>
@endif

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
        <tr>
          <th class="py-3.5 px-5 text-left">Role</th>
          <th class="py-3.5 px-5 text-center w-24">Jenis</th>
          <th class="py-3.5 px-5 text-center w-24">Pengguna</th>
          <th class="py-3.5 px-5 text-center w-28">Izin</th>
          <th class="py-3.5 px-5 text-center w-14">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200">
        @foreach($roles as $r)
          @php
            $isSeeded = in_array($r->name, \Database\Seeders\RolePermissionSeeder::SEEDED_ROLES);
          @endphp
          <tr class="h-[52px] hover:bg-slate-50">
            <td class="px-5 py-3.5 font-medium text-slate-900">{{ $r->name }}</td>
            <td class="px-5 py-3.5 text-center">
              @if($isSeeded)
                <span class="inline-flex px-2 py-0.5 rounded text-xs bg-slate-900 text-white border border-slate-900">Sistem</span>
              @else
                <span class="inline-flex px-2 py-0.5 rounded text-xs bg-white text-slate-600 border border-slate-200">Kustom</span>
              @endif
            </td>
            <td class="px-5 py-3.5 text-center tabular-nums">{{ $r->users_count }}</td>
            <td class="px-5 py-3.5 text-center tabular-nums whitespace-nowrap">{{ $r->permissions_count ?? $r->permissions->count() }} dari {{ $totalPerms }}</td>
            <td class="px-5 py-3.5 text-center">
              <a href="{{ route('system.roles.edit', $r) }}" class="w-8 h-8 inline-flex items-center justify-center text-slate-500 hover:text-primary rounded hover:bg-slate-100" title="Ubah"><span class="material-symbols-outlined text-lg">edit</span></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
