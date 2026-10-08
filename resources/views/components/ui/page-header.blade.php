@props(['title' => null, 'subtitle' => null])
@php
$currentRoute = Route::currentRouteName() ?? '';
$navPage = collect(config('navigation.pages'))->firstWhere('route', $currentRoute);
$page = $navPage;
if ($title !== null) {
    $page = $page ? array_merge($page, ['title' => $title]) : ['title' => $title, 'label' => $title, 'group' => null, 'subtitle' => $subtitle, 'action' => null];
    if ($subtitle !== null) $page['subtitle'] = $subtitle;
}
$action = $page['action'] ?? null;
$showAction = false; $actionHref = '#'; $actionIcon = 'add'; $actionLabel = '';
if ($action && !empty($action['label'])) {
    $perm = $action['permission'] ?? null;
    $allowed = empty($perm) || (auth()->check() && auth()->user()->can($perm));
    if ($allowed) {
        $showAction = true;
        $actionHref = !empty($action['route']) && Route::has($action['route']) ? route($action['route']) : '#';
        $actionIcon = $action['icon'] ?? 'add';
        $actionLabel = $action['label'];
    }
}
@endphp
@if($page)
<div class="flex items-center justify-between gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-semibold text-slate-900 tracking-tight">{{ $page['title'] ?? $page['label'] }}</h1>
    @if(!empty($page['subtitle']))<p class="text-sm text-slate-500 mt-1">{{ $page['subtitle'] }}</p>@endif
  </div>
  @if($showAction)
    @if($actionHref !== '#')
    <a href="{{ $actionHref }}" class="shrink-0 inline-flex items-center gap-1.5 h-10 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
      <span class="material-symbols-outlined text-lg">{{ $actionIcon }}</span><span>{{ $actionLabel }}</span>
    </a>
    @else
    <button type="button" onclick="if(typeof openModal==='function')openModal('create')" class="shrink-0 inline-flex items-center gap-1.5 h-10 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
      <span class="material-symbols-outlined text-lg">{{ $actionIcon }}</span><span>{{ $actionLabel }}</span>
    </button>
    @endif
  @endif
</div>
@endif
