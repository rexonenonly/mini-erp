@php
$currentRoute = Route::currentRouteName() ?? '';
$page = collect(config('navigation.pages'))->firstWhere('route', $currentRoute);
@endphp
@if($page)
<div class="flex items-start justify-between gap-4 mb-6">
  <div>
    <div class="text-xs text-slate-400 mb-1">
      @if($page['group']){{ $page['group'] }} <span class="mx-1">/</span> @endif{{ $page['label'] }}
    </div>
    <h1 class="text-2xl font-semibold text-slate-900 tracking-tight">{{ $page['title'] ?? $page['label'] }}</h1>
    @if(!empty($page['subtitle']))
      <p class="text-sm text-slate-500 mt-1">{{ $page['subtitle'] }}</p>
    @endif
  </div>
  @if(!empty($page['action']))
    @php
      $action = $page['action'];
      $href = !empty($action['route']) && Route::has($action['route']) ? route($action['route']) : '#';
      $icon = $action['icon'] ?? 'add';
    @endphp
    <a href="{{ $href }}" class="shrink-0 inline-flex items-center gap-1.5 h-9 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
      <span class="material-symbols-outlined text-lg">{{ $icon }}</span>
      <span>{{ $action['label'] }}</span>
    </a>
  @endif
</div>
@endif
