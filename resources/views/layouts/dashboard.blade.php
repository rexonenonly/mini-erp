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

  <!-- SIDEBAR -->
  <aside class="w-[240px] bg-sidebar text-slate-200 flex flex-col shrink-0 min-h-screen border-r border-slate-800 select-none">
    <div class="px-5 py-5 border-b border-slate-800/80">
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded bg-primary flex items-center justify-center text-white font-bold text-base tracking-tight">M</div>
        <div class="font-bold text-lg text-white tracking-tight">MiniERP</div>
      </div>
      <div class="text-xs text-sidebar-muted mt-1 leading-tight truncate">PT Distribusi Mandiri Utama</div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
      <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm transition-colors {{ request()->is('dashboard') ? 'bg-sidebar-active text-white font-medium' : 'text-sidebar-muted hover:bg-sidebar-hover hover:text-white' }}">
        <span class="material-symbols-outlined {{ request()->is('dashboard') ? 'text-white' : '' }}">dashboard</span>
        <span>Dashboard</span>
      </a>
      <a href="/master-data" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm transition-colors {{ request()->is('master-data*') ? 'bg-sidebar-active text-white font-medium' : 'text-sidebar-muted hover:bg-sidebar-hover hover:text-white' }}">
        <span class="material-symbols-outlined">dataset</span>
        <span>Master Data</span>
      </a>
      <a href="/inventory" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm transition-colors {{ request()->is('inventory') ? 'bg-sidebar-active text-white font-medium' : 'text-sidebar-muted hover:bg-sidebar-hover hover:text-white' }}">
        <span class="material-symbols-outlined {{ request()->is('inventory') ? 'text-white' : '' }}">inventory_2</span>
        <span>Inventory</span>
      </a>
      <a href="/purchasing" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm transition-colors {{ request()->is('purchasing') ? 'bg-sidebar-active text-white font-medium' : 'text-sidebar-muted hover:bg-sidebar-hover hover:text-white' }}">
        <span class="material-symbols-outlined {{ request()->is('purchasing') ? 'text-white' : '' }}">shopping_cart</span>
        <span>Purchasing</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sidebar-muted hover:bg-sidebar-hover hover:text-white text-sm transition-colors">
        <span class="material-symbols-outlined">point_of_sale</span>
        <span>Sales</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sidebar-muted hover:bg-sidebar-hover hover:text-white text-sm transition-colors">
        <span class="material-symbols-outlined">account_balance</span>
        <span>Accounting</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sidebar-muted hover:bg-sidebar-hover hover:text-white text-sm transition-colors">
        <span class="material-symbols-outlined">bar_chart</span>
        <span>Laporan</span>
      </a>

      <div class="pt-4 pb-2">
        <div class="h-px bg-slate-800 mx-1"></div>
        <div class="px-3 pt-3 pb-1 text-xs font-semibold uppercase tracking-wider text-slate-500">Sistem</div>
      </div>

      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-sidebar-muted hover:bg-sidebar-hover hover:text-white text-sm transition-colors">
        <span class="material-symbols-outlined">group</span>
        <span>Pengguna & Role</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-sidebar-muted hover:bg-sidebar-hover hover:text-white text-sm transition-colors">
        <span class="material-symbols-outlined">history</span>
        <span>Audit Log</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-sidebar-muted hover:bg-sidebar-hover hover:text-white text-sm transition-colors">
        <span class="material-symbols-outlined">health_and_safety</span>
        <span>Kesehatan Sistem</span>
      </a>
    </nav>

    <div class="p-4 border-t border-slate-800/80 bg-slate-950/40 text-xs">
      <div class="text-slate-400">Periode Akuntansi:</div>
      <div class="font-medium text-slate-200 mt-0.5 flex items-center justify-between">
        <span>Oktober 2026</span>
        <span class="inline-block text-xs font-medium text-emerald-400 bg-emerald-950/70 border border-emerald-800/60 px-1.5 py-0.5 rounded">Open</span>
      </div>
    </div>
  </aside>

  <!-- MAIN WRAPPER -->
  <div class="flex-1 flex flex-col min-w-0">
    <!-- TOPBAR -->
    <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between gap-4 shrink-0">
      <div class="flex items-center gap-4">
        <h1 class="text-xl font-semibold text-slate-900 tracking-tight">@yield('page-title', 'Dashboard')</h1>
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
            <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined text-slate-400 text-lg">shopping_cart</span>
              <span>Purchase Order</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
              <span class="material-symbols-outlined text-slate-400 text-lg">point_of_sale</span>
              <span>Sales Order</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100">
              <span class="material-symbols-outlined text-slate-400 text-lg">tune</span>
              <span>Opname Stok</span>
            </a>
          </div>
        </div>

        <button type="button" class="w-9 h-9 rounded-lg border border-slate-200 hover:bg-slate-50 flex items-center justify-center text-slate-600 hover:text-slate-900 transition-colors relative">
          <span class="material-symbols-outlined text-xl">notifications</span>
          <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>
        </button>

        <div class="h-6 w-px bg-slate-200"></div>

        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center font-semibold text-slate-700 text-sm select-none">RP</div>
          <div class="flex flex-col text-left">
            <span class="text-sm font-semibold text-slate-800 leading-tight">Rex Pradana</span>
            <span class="text-xs text-slate-500 leading-tight">Owner</span>
          </div>
        </div>
      </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-6 space-y-6 overflow-y-auto">
      @yield('content')
    </main>
  </div>

</body>
</html>
