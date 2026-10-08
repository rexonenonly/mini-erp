@extends('layouts.app')
@section('title', $isEdit ? 'Ubah Role' : 'Role Baru')
@section('content')
@php
  $isOwner = $role && $role->name === 'Owner';
  $isSeeded = $role && in_array($role->name, \Database\Seeders\RolePermissionSeeder::SEEDED_ROLES);
  $breadcrumb = $isEdit ? 'Sistem / Role & Izin / Ubah' : 'Sistem / Role & Izin / Baru';
  $pageTitle = $isEdit ? 'Ubah Role' : 'Role Baru';
@endphp
<x-ui.page-header :title="$pageTitle" subtitle="Atur hak akses setiap role" :breadcrumb="$breadcrumb" />

@if($isOwner)
  <div class="mb-4 p-3 rounded-lg bg-amber-50 border border-amber-200 text-sm text-amber-800">Role Owner memiliki semua izin dan tidak dapat diubah.</div>
@endif
@if($errors->any())
  <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
    <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif

<form method="POST" action="{{ $isEdit ? route('system.roles.update', $role) : route('system.roles.store') }}" id="roleForm">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">
    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama Role <span class="text-red-500">*</span></label>
    <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" @if($isOwner || $isSeeded) readonly @endif required
      class="w-full max-w-md h-9 px-3 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary @if($isOwner || $isSeeded) bg-slate-50 text-slate-500 @endif"
      placeholder="Nama role">
    @if($isSeeded && !$isOwner)<p class="text-xs text-slate-500 mt-1">Role sistem tidak dapat diganti namanya.</p>@endif
  </div>

  @foreach($groups as $groupName => $resources)
    @php $groupPerms = []; foreach($resources as $res => $meta){ foreach($meta['actions'] as $a){ $groupPerms[] = "$res.$a"; } } @endphp
    <div class="bg-white border border-slate-200 rounded-lg mb-4 overflow-hidden" data-group-card>
      <div class="px-5 py-3 border-b border-slate-200 flex items-center justify-between bg-slate-50">
        <h3 class="text-sm font-semibold text-slate-900">{{ $groupName }}</h3>
        @if(!$isOwner)
          <label class="flex items-center gap-1.5 text-xs text-slate-600 cursor-pointer select-none">
            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary group-select-all" data-group="{{ $groupName }}"> Pilih semua
          </label>
        @endif
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-white border-b border-slate-200 text-xs uppercase text-slate-500">
            <tr>
              <th class="py-2.5 px-4 text-left font-medium">Resource</th>
              @foreach($allActions as $act)
                <th class="py-2.5 px-2 text-center font-medium w-14">{{ $actionLabels[$act] }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            @foreach($resources as $resource => $meta)
              <tr class="h-[52px] hover:bg-slate-50" data-resource="{{ $resource }}">
                <td class="px-4 py-2.5 font-medium text-slate-700 whitespace-nowrap">{{ $meta['label'] }}</td>
                @foreach($allActions as $act)
                  @php
                    $perm = "$resource.$act";
                    $hasAction = in_array($act, $meta['actions']);
                    $checked = in_array($perm, old('permissions', $selected));
                    $isView = $act === 'view';
                  @endphp
                  <td class="px-2 py-2.5 text-center">
                    @if($hasAction)
                      <input type="checkbox" name="permissions[]" value="{{ $perm }}" @checked($checked) @disabled($isOwner)
                        class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary perm-checkbox @if($isView) perm-view @endif"
                        data-resource="{{ $resource }}" data-action="{{ $act }}">
                    @else
                      <span class="text-slate-300">-</span>
                    @endif
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endforeach

  @if(!$isOwner)
    <div class="sticky bottom-0 bg-white border border-slate-200 rounded-lg p-4 flex items-center gap-3 shadow-lg">
      <button type="submit" class="h-9 px-5 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg shadow-sm transition-colors">Simpan</button>
      <a href="{{ route('system.roles') }}" class="h-9 inline-flex items-center px-5 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Batal</a>
    </div>
  @else
    <div class="flex items-center gap-3">
      <a href="{{ route('system.roles') }}" class="h-9 inline-flex items-center px-5 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Kembali</a>
    </div>
  @endif
</form>

@if(!$isOwner)
<script>
(function(){
  const form = document.getElementById('roleForm');
  if(!form) return;
  // dependency: non-view requires view; unchecking view unchecks others in row
  form.addEventListener('change', function(e){
    if(!e.target.classList.contains('perm-checkbox')) return;
    const cb = e.target;
    const res = cb.dataset.resource;
    const act = cb.dataset.action;
    const row = cb.closest('tr');
    if(!row) return;
    if(act !== 'view'){
      if(cb.checked){
        const viewCb = row.querySelector('.perm-view');
        if(viewCb && !viewCb.checked) viewCb.checked = true;
      }
    } else {
      if(!cb.checked){
        row.querySelectorAll('.perm-checkbox:not(.perm-view)').forEach(function(c){ c.checked = false; });
      }
    }
    syncGroup(cb.closest('[data-group-card]'));
  });
  function syncGroup(card){
    if(!card) return;
    const all = card.querySelectorAll('.perm-checkbox:not(:disabled)');
    const checked = card.querySelectorAll('.perm-checkbox:checked');
    const sel = card.querySelector('.group-select-all');
    if(sel) sel.checked = all.length > 0 && all.length === checked.length;
    sel.indeterminate = checked.length > 0 && checked.length < all.length;
  }
  document.querySelectorAll('.group-select-all').forEach(function(sel){
    const card = sel.closest('[data-group-card]');
    syncGroup(card);
    sel.addEventListener('change', function(){
      const on = sel.checked;
      card.querySelectorAll('.perm-checkbox:not(:disabled)').forEach(function(c){ c.checked = on; });
      // enforce view when turning on
      if(on){
        card.querySelectorAll('tr').forEach(function(row){
          if(row.querySelectorAll('.perm-checkbox:checked:not(.perm-view)').length>0){
            const v=row.querySelector('.perm-view');
            if(v) v.checked=true;
          }
        });
      }
    });
  });
  // initial sync for dependency (server already enforces, but UI ensure)
  document.querySelectorAll('tr').forEach(function(row){
    if(row.querySelectorAll('.perm-checkbox:checked:not(.perm-view)').length>0){
      const v=row.querySelector('.perm-view'); if(v) v.checked=true;
    }
  });
})();
</script>
@endif

@if($isEdit && !$isOwner && !$isSeeded)
  <div class="mt-6 bg-white border border-slate-200 rounded-lg p-5">
    <h3 class="text-sm font-semibold text-slate-900">Hapus Role</h3>
    <p class="text-xs text-slate-500 mt-1">Role hanya dapat dihapus jika tidak memiliki pengguna.</p>
    <form method="POST" action="{{ route('system.roles.destroy', $role) }}" class="mt-3" onsubmit="return confirm('Hapus role ini?')">
      @csrf @method('DELETE')
      <button type="submit" class="h-9 px-4 rounded-lg text-sm font-medium border bg-white border-red-300 text-red-700 hover:bg-red-50">Hapus Role</button>
    </form>
  </div>
@endif
@endsection
