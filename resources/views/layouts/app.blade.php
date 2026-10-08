<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'MiniERP')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            mono: ['JetBrains Mono', 'monospace'],
          },
          colors: {
            sidebar: '#0f172a',
            'sidebar-hover': '#1e293b',
            'sidebar-active': '#2563eb',
            'sidebar-muted': '#94a3b8',
            primary: '#2563eb',
            'primary-hover': '#1d4ed8',
          }
        }
      }
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
      font-size: 20px;
      line-height: 1;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    body {
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      color: #1e293b;
      background-color: #f8fafc;
      -webkit-font-smoothing: antialiased;
    }
  </style>
</head>
<body class="min-h-screen flex bg-slate-50 text-slate-800">

  <x-layout.sidebar />

  <!-- MAIN WRAPPER -->
  <div class="flex-1 flex flex-col min-w-0">
    <!-- TOPBAR -->
    <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between gap-4 shrink-0">
      <div class="flex items-center gap-4">
        <nav class="text-sm text-slate-500">
          @php
            $cr = Route::currentRouteName();
            $cp = collect(config('navigation.pages'))->firstWhere('route', $cr);
          @endphp
          @if($cp)
            @if($cp['group'])<span>{{ $cp['group'] }}</span><span class="mx-1.5 text-slate-300">/</span>@endif
            <span class="text-slate-900 font-medium">{{ $cp['label'] }}</span>
          @else
            <span class="text-slate-900 font-medium">MiniERP</span>
          @endif
        </nav>
      </div>

      <div class="flex-1 max-w-md mx-4">
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">search</span>
          <input type="text" placeholder="Cari SKU, PO, SO, atau jurnal..." class="w-full h-9 pl-9 pr-4 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary transition-all">
        </div>
      </div>

      <div class="flex items-center gap-4">
        <div class="relative group">
          <button type="button" class="h-9 px-3.5 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg flex items-center gap-1.5 shadow-sm transition-colors">
            <span class="material-symbols-outlined text-lg">add</span>
            <span>Transaksi Baru</span>
            <span class="material-symbols-outlined text-base text-blue-200 ml-0.5">expand_more</span>
          </button>
          <div class="absolute right-0 mt-1 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-1.5 hidden group-hover:block z-20">
            @can('purchasing.purchase-orders.view')
            <a href="{{ route('purchasing.orders') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined text-slate-400 text-lg">shopping_cart</span>
              <span>Purchase Order</span>
            </a>
            @endcan
            @can('sales.sales-orders.view')
            <a href="{{ route('sales.orders') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined text-slate-400 text-lg">point_of_sale</span>
              <span>Sales Order</span>
            </a>
            @endcan
            @can('inventory.stock-opnames.view')
            <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100">
              <span class="material-symbols-outlined text-slate-400 text-lg">tune</span>
              <span>Opname Stok</span>
            </a>
            @endcan
          </div>
        </div>

        <button type="button" class="w-9 h-9 rounded-lg border border-slate-200 hover:bg-slate-50 flex items-center justify-center text-slate-600 hover:text-slate-900 transition-colors relative">
          <span class="material-symbols-outlined text-xl">notifications</span>
          <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>
        </button>

        <div class="h-6 w-px bg-slate-200"></div>

        @auth
        @php
          $u = auth()->user();
          $initials = collect(explode(' ', $u->name))->map(fn($p)=>mb_strtoupper(mb_substr($p,0,1)))->take(2)->implode('');
          $roleName = $u->getRoleNames()->first() ?? '-';
        @endphp
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center font-semibold text-slate-700 text-sm select-none">{{ $initials }}</div>
          <div class="flex flex-col text-left">
            <span class="text-sm font-semibold text-slate-800 leading-tight">{{ $u->name }}</span>
            <span class="text-xs text-slate-500 leading-tight">{{ $roleName }}</span>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="ml-2">
            @csrf
            <button type="submit" class="w-8 h-8 inline-flex items-center justify-center rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-500 hover:text-slate-900" title="Keluar">
              <span class="material-symbols-outlined text-lg">logout</span>
            </button>
          </form>
        </div>
        @else
        <a href="{{ route('login') }}" class="text-sm font-medium text-primary hover:text-primary-hover">Masuk</a>
        @endauth
      </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-6 space-y-6 overflow-y-auto">
      @yield('content')
    </main>
  </div>

</body>
</html>
