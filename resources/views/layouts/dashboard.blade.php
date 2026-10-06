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
            primary: '#2563eb',
            'primary-hover': '#1d4ed8',
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20; }
  </style>
</head>
<body class="min-h-screen flex bg-slate-50">

  <aside class="w-60 bg-slate-900 text-white flex-shrink-0 flex flex-col fixed inset-y-0 left-0 z-30">
    <div class="h-16 px-5 flex items-center gap-3 border-b border-slate-800">
      <div class="w-8 h-8 rounded bg-primary flex items-center justify-center font-bold">M</div>
      <div class="flex flex-col min-w-0">
        <span class="font-bold text-sm">MiniERP</span>
        <span class="text-xs text-slate-400 truncate">PT Distribusi Mandiri Utama</span>
      </div>
    </div>

    <nav class="p-3 space-y-1 flex-1">
      <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">dashboard</span>
        <span>Dashboard</span>
      </a>
      <a href="/master-data/products" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">grid_view</span>
        <span>Master Data</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">inventory_2</span>
        <span>Inventory</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">shopping_cart</span>
        <span>Purchasing</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">point_of_sale</span>
        <span>Sales</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">account_balance</span>
        <span>Accounting</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">bar_chart</span>
        <span>Laporan</span>
      </a>

      <div class="pt-4 pb-1 px-3">
        <p class="text-xs font-semibold text-slate-500 uppercase">Sistem</p>
      </div>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">group</span>
        <span>Pengguna & Role</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">history</span>
        <span>Audit Log</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">
        <span class="material-symbols-outlined text-xl">verified_user</span>
        <span>Kesehatan Sistem</span>
      </a>
    </nav>

    <div class="p-4 border-t border-slate-800">
      <div class="text-xs text-slate-400">
        <span class="block text-slate-500 font-medium">Periode Akuntansi:</span>
        <div class="flex items-center justify-between mt-1">
          <span class="font-medium text-slate-200">Oktober 2026</span>
          <span class="px-1.5 py-0.5 rounded text-xs bg-emerald-950 text-emerald-400 border border-emerald-800/60">Open</span>
        </div>
      </div>
    </div>
  </aside>

  <div class="flex-1 flex flex-col min-w-0 pl-60">
    <header class="h-16 bg-white border-b px-8 flex items-center justify-between sticky top-0 z-20">
      <div class="flex items-center gap-2 text-sm text-slate-500">
        <span>Operasional</span>
        <span>/</span>
        <span class="font-semibold text-slate-900">@yield('breadcrumb', 'Dashboard')</span>
      </div>

      <div class="flex items-center gap-4">
        <input type="text" placeholder="Cari SKU, PO, SO, atau jurnal..." class="w-80 h-9 pl-3 bg-slate-50 border rounded-lg text-sm">
        <button class="w-9 h-9 flex items-center justify-center rounded-lg border">
          <span class="material-symbols-outlined text-xl">notifications</span>
        </button>
        <div class="flex items-center gap-3 pl-1 border-l ml-1">
          <div class="w-9 h-9 rounded-full bg-slate-100 border flex items-center justify-center text-sm font-semibold">RP</div>
          <div class="flex flex-col text-left">
            <span class="text-sm font-semibold leading-none">Rex Pradana</span>
            <span class="text-xs text-slate-500 mt-1 leading-none">Owner</span>
          </div>
        </div>
      </div>
    </header>

    <main class="flex-1 p-8 max-w-7xl w-full mx-auto">
      @yield('content')
    </main>
  </div>

</body>
</html>
