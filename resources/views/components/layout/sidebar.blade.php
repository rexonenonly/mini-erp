@php
$pages = config('navigation.pages');
$system = config('navigation.system', []);
$current = Route::currentRouteName() ?? '';
$canView = function($perm) {
    if (empty($perm)) return true;
    if (! auth()->check()) return false;
    return auth()->user()->can($perm);
};
$groups = [];
$standalone = null;
foreach ($pages as $p) {
    if (($p['group'] ?? null) === 'Sistem') continue;
    if (($p['group'] ?? null) === null) { $standalone = $p; continue; }
    if (! $canView($p['permission'] ?? null)) continue;
    $groups[$p['group']][] = $p;
}
$groups = array_filter($groups, fn($items) => count($items) > 0);
$openGroup = null;
foreach ($groups as $name => $items) {
    foreach ($items as $item) {
        if ($current === $item['route'] || str_starts_with($current, $item['route'] . '.')) { $openGroup = $name; break 2; }
    }
}
$groupIcons = ['Master Data'=>'dataset','Inventory'=>'inventory_2','Purchasing'=>'shopping_cart','Sales'=>'point_of_sale','Accounting'=>'account_balance','Laporan'=>'bar_chart'];
@endphp
<aside class="w-[240px] bg-sidebar text-slate-200 flex flex-col shrink-0 h-screen sticky top-0 border-r border-slate-800 select-none">
  <div class="px-5 py-5 border-b border-slate-800/80 shrink-0">
    <div class="flex items-center gap-2">
      <div class="w-7 h-7 rounded bg-primary flex items-center justify-center text-white font-bold text-base tracking-tight">M</div>
      <div class="font-bold text-lg text-white tracking-tight">MiniERP</div>
    </div>
    <div class="text-xs text-sidebar-muted mt-1 leading-tight truncate">PT Distribusi Mandiri Utama</div>
  </div>
  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto min-h-0">
    @if($standalone)
    @php $dashActive = $current === $standalone['route']; @endphp
    <a href="{{ route($standalone['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm transition-colors {{ $dashActive ? 'bg-sidebar-active text-white font-medium' : 'text-sidebar-muted hover:bg-sidebar-hover hover:text-white' }}">
      <span class="material-symbols-outlined">{{ $standalone['icon'] }}</span><span>{{ $standalone['label'] }}</span>
    </a>
    @endif
    @foreach($groups as $groupName => $items)
    @php $isopen = $openGroup === $groupName; @endphp
    <details name="sidebar" {{ $isopen ? 'open' : '' }} class="group">
      <summary class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-sidebar-muted hover:bg-sidebar-hover hover:text-white cursor-pointer transition-colors list-none [&::-webkit-details-marker]:hidden" aria-expanded="{{ $isopen ? 'true' : 'false' }}">
        <span class="material-symbols-outlined">{{ $groupIcons[$groupName] ?? 'folder' }}</span><span class="flex-1">{{ $groupName }}</span><span class="material-symbols-outlined text-base text-slate-500 group-open:rotate-180 transition-transform">expand_more</span>
      </summary>
      <div class="ml-3 mt-0.5 space-y-0.5 border-l border-slate-700/50 pl-2">
        @foreach($items as $item)
        @php $active = $current === $item['route'] || str_starts_with($current, $item['route'] . '.'); @endphp
        <a href="{{ route($item['route']) }}" class="flex items-center gap-2.5 pl-3 pr-3 py-2 rounded-md text-[13px] transition-colors {{ $active ? 'bg-sidebar-active/20 text-white font-medium border-l-2 border-primary -ml-px pl-[10px]' : 'text-slate-400 hover:bg-sidebar-hover hover:text-white' }}">
          <span class="material-symbols-outlined text-[18px]">{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span>
        </a>
        @endforeach
      </div>
    </details>
    @endforeach
    @php $sysItems = array_filter($system, fn($s) => Route::has($s['route']) && $canView($s['permission'] ?? null)); @endphp
    @if(count($sysItems) > 0)
    <div class="pt-4 pb-2"><div class="h-px bg-slate-800 mx-1"></div><div class="px-3 pt-3 pb-1 text-xs font-semibold uppercase tracking-wider text-slate-500">Sistem</div></div>
    @foreach($sysItems as $s)
    @php $sysActive = $current === $s['route'] || str_starts_with($current, $s['route'] . '.'); @endphp
    <a href="{{ route($s['route']) }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors {{ $sysActive ? 'bg-sidebar-active text-white font-medium' : 'text-sidebar-muted hover:bg-sidebar-hover hover:text-white' }}">
      <span class="material-symbols-outlined">{{ $s['icon'] }}</span><span>{{ $s['label'] }}</span>
    </a>
    @endforeach
    @endif
  </nav>
  <div class="p-4 border-t border-slate-800/80 bg-slate-950/40 text-xs shrink-0">
    <div class="text-slate-400">Periode Akuntansi:</div>
    <div class="font-medium text-slate-200 mt-0.5 flex items-center justify-between"><span>Oktober 2026</span><span class="inline-block text-xs font-medium text-emerald-400 bg-emerald-950/70 border border-emerald-800/60 px-1.5 py-0.5 rounded">Open</span></div>
  </div>
</aside>
<script>document.querySelectorAll('details[name="sidebar"]').forEach(function(d){var s=d.querySelector('summary');var sync=function(){if(s)s.setAttribute('aria-expanded',d.hasAttribute('open')?'true':'false');};d.addEventListener('toggle',sync);sync();});</script>
