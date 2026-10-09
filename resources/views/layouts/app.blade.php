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
    .inventory-page { min-width: 0; max-width: 100%; }
    .inventory-page .inventory-toolbar { min-width: 0; flex-wrap: wrap; }
    .inventory-page .inventory-toolbar > div:first-child { min-width: 0; flex-wrap: wrap; }
    .inventory-page .inventory-table { width: 100%; }
    .inventory-page .inventory-table th,
    .inventory-page .inventory-table td { vertical-align: middle; white-space: nowrap; }
    .inventory-page .inventory-table tbody tr { height: 52px; }
    .inventory-page .inventory-table .product-name { min-width: 220px; white-space: normal; }
    .inventory-page .inventory-table .warehouse { min-width: 128px; }
    .inventory-page .inventory-table .numeric { min-width: 96px; font-variant-numeric: tabular-nums; }
    .inventory-page .inventory-table .currency { min-width: 132px; font-variant-numeric: tabular-nums; }
    .inventory-page .inventory-table th.text-right,
    .inventory-page .inventory-table td.text-right { min-width: 96px; font-variant-numeric: tabular-nums; }
    .inventory-page .stock-table th:nth-child(2),
    .inventory-page .stock-table td:nth-child(2) { min-width: 220px; white-space: normal; }
    .inventory-page .stock-table th:nth-child(3),
    .inventory-page .stock-table td:nth-child(3) { min-width: 128px; }
    .inventory-page select { height: 36px; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #fff; }
    .inventory-page input[type='search'] { border-color: #e2e8f0; background: #fff; }
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
          <button type="button" class="h-9 px-3.5 bg-white border border-slate-300 hover:bg-blue-50 hover:border-blue-400 text-primary text-sm font-medium rounded-lg flex items-center gap-1.5 transition-colors">
            <span class="material-symbols-outlined text-lg">add</span>
            <span>Transaksi Baru</span>
            <span class="material-symbols-outlined text-base text-slate-400 ml-0.5">expand_more</span>
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

  <!-- MODAL -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target===this) closeModal()">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
      <div class="p-5 border-b border-slate-200 flex items-center justify-between">
        <h3 id="modalTitle" class="text-lg font-semibold text-slate-900"></h3>
        <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <div id="modalBody" class="p-6 overflow-y-auto flex-1"></div>
      <div id="modalFooter" class="p-5 border-t border-slate-200 flex items-center justify-end gap-3"></div>
    </div>
  </div>

  <!-- DELETE CONFIRM -->
  <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target===this) closeDeleteModal()">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md" onclick="event.stopPropagation()">
      <div class="p-6">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-red-600 text-2xl">warning</span>
          </div>
          <div class="flex-1">
            <h3 class="text-lg font-semibold text-slate-900 mb-1">Konfirmasi Hapus</h3>
            <p class="text-sm text-slate-600">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
          </div>
        </div>
      </div>
      <div class="p-5 bg-slate-50 rounded-b-lg flex items-center justify-end gap-3">
        <button onclick="closeDeleteModal()" class="h-9 px-4 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Batal</button>
        <button onclick="executeDelete()" class="h-9 px-4 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">Hapus</button>
      </div>
    </div>
  </div>

  @stack('scripts')
  @php 
    $productsJson = \App\Models\Product::where('is_active', true)->get(['id', 'sku', 'name'])->toJson();
  @endphp
  <script>
  const PRODUCTS = {!! $productsJson !!};
  let currentDeleteId = null;

  function openModal(mode, id = null) {
    const modal = document.getElementById('modal');
    const title = document.getElementById('modalTitle');
    const body = document.getElementById('modalBody');
    const footer = document.getElementById('modalFooter');
    
    if (mode === 'create') {
      title.textContent = 'Tambah Data';
      body.innerHTML = '<div class="text-center py-4 text-slate-500">Loading form...</div>';
      footer.innerHTML = `
        <button onclick="closeModal()" class="h-9 px-4 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Batal</button>
        <button onclick="submitForm()" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg">Simpan</button>
      `;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      loadForm(mode);
    } else if (mode === 'view' || mode === 'edit') {
      title.textContent = mode === 'view' ? 'Detail Data' : 'Ubah Data';
      body.innerHTML = '<div class="text-center py-4 text-slate-500">Loading...</div>';
      if (mode === 'view') {
        footer.innerHTML = '<button onclick="closeModal()" class="h-9 px-4 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Tutup</button>';
      } else {
        footer.innerHTML = `
          <button onclick="closeModal()" class="h-9 px-4 border border-slate-200 rounded-lg text-sm bg-white hover:bg-slate-50 text-slate-700">Batal</button>
          <button onclick="submitForm(${id})" class="h-9 px-4 bg-primary hover:bg-primary-hover text-white text-sm font-medium rounded-lg">Simpan</button>
        `;
      }
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      loadData(id, mode);
    }
  }

  function closeModal() {
    const modal = document.getElementById('modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function confirmDelete(id) {
    currentDeleteId = id;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteModal() {
    currentDeleteId = null;
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function executeDelete() {
    if (!currentDeleteId) return;
    fetch(`${resourceBase()}/${currentDeleteId}`, {
      method: 'DELETE',
      headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
    })
    .then(r => r.json())
    .then(d => {
      closeDeleteModal();
      if (d.success) location.reload();
      else alert(d.message || 'Gagal menghapus data');
    })
    .catch(() => alert('Terjadi kesalahan'));
  }

  function loadForm(mode, data = {}) {
    // ponytail: dynamic form per resource, add when fields vary significantly
    const body = document.getElementById('modalBody');
    const fields = getFormFields(resource, data);
    body.innerHTML = `<form id="dataForm" class="space-y-4">${fields}</form>`;
  }

  function resourceBase() {
  const map = {
    'products': @json(route('master-data.products')),
    'warehouses': @json(route('master-data.warehouses')),
    'partners': @json(route('master-data.partners')),
    'accounts': @json(route('master-data.accounts')),
    'stock': @json(route('inventory.stock')),
    'stock-opnames': @json(url('/master-data/stock-opnames')),
    'stock-transfers': @json(url('/master-data/stock-transfers')),
    'purchase-orders': @json(url('/purchasing/purchase-orders')),
    'goods-receipts': @json(url('/purchasing/goods-receipts')),
    'vendor-bills': @json(url('/purchasing/vendor-bills')),
    'supplier-payments': @json(url('/purchasing/supplier-payments')),
    'sales-orders': @json(url('/sales/sales-orders')),
    'deliveries': @json(url('/sales/deliveries')),
    'invoices': @json(url('/sales/invoices')),
    'customer-payments': @json(url('/sales/customer-payments')),
  };
  return map[resource] || '/' + (resource || '');
}

function loadData(id, mode) {
    fetch(`${resourceBase()}/${id}`, {headers: {'Accept': 'application/json'}})
    .then(r => r.json())
    .then(data => {
      if (mode === 'view') renderView(data);
      else loadForm(mode, data);
    })
    .catch(() => {
      document.getElementById('modalBody').innerHTML = '<div class="text-center py-4 text-red-600">Gagal memuat data</div>';
    });
  }

  function renderView(data) {
    const body = document.getElementById('modalBody');
    const fields = getViewFields(resource, data);
    body.innerHTML = `<div class="space-y-4">${fields}</div>`;
  }

  function getFormFields(res, data) {
    const d = data || {};
    const disabled = Object.keys(data).length > 0 && !canUpdate ? 'disabled' : '';
    if (res === 'products') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">SKU <span class="text-red-500">*</span></label><input type="text" name="sku" value="${d.sku||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nama Produk <span class="text-red-500">*</span></label><input type="text" name="name" value="${d.name||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Satuan <span class="text-red-500">*</span></label><input type="text" name="unit" value="${d.unit||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Harga Beli <span class="text-red-500">*</span></label><input type="number" name="purchase_price" value="${d.purchase_price||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Harga Jual <span class="text-red-500">*</span></label><input type="number" name="sale_price" value="${d.sale_price||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Stok Minimum <span class="text-red-500">*</span></label><input type="number" name="min_stock" value="${d.min_stock||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" ${d.is_active||!Object.keys(data).length?'checked':''} ${disabled} class="w-4 h-4 rounded"><span class="text-sm text-slate-700">Aktif</span></label></div>
      `;
    }
    if (res === 'warehouses') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kode <span class="text-red-500">*</span></label><input type="text" name="code" value="${d.code||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nama Gudang <span class="text-red-500">*</span></label><input type="text" name="name" value="${d.name||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Alamat</label><textarea name="address" rows="3" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.address||''}</textarea></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Telepon</label><input type="text" name="phone" value="${d.phone||''}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" ${d.is_active||!Object.keys(data).length?'checked':''} ${disabled} class="w-4 h-4 rounded"><span class="text-sm text-slate-700">Aktif</span></label></div>
      `;
    }
    if (res === 'partners') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kode <span class="text-red-500">*</span></label><input type="text" name="code" value="${d.code||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nama Mitra <span class="text-red-500">*</span></label><input type="text" name="name" value="${d.name||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tipe <span class="text-red-500">*</span></label><select name="type" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="customer" ${d.type==='customer'?'selected':''}>Customer</option><option value="supplier" ${d.type==='supplier'?'selected':''}>Supplier</option><option value="both" ${d.type==='both'||!d.type?'selected':''}>Both</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kontak Person</label><input type="text" name="contact_person" value="${d.contact_person||''}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Telepon</label><input type="text" name="phone" value="${d.phone||''}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Email</label><input type="email" name="email" value="${d.email||''}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Alamat</label><textarea name="address" rows="3" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.address||''}</textarea></div>
        <div><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" ${d.is_active||!Object.keys(data).length?'checked':''} ${disabled} class="w-4 h-4 rounded"><span class="text-sm text-slate-700">Aktif</span></label></div>
      `;
    }
    if (res === 'accounts') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kode <span class="text-red-500">*</span></label><input type="text" name="code" value="${d.code||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nama Akun <span class="text-red-500">*</span></label><input type="text" name="name" value="${d.name||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tipe <span class="text-red-500">*</span></label><select name="type" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="asset" ${d.type==='asset'||!d.type?'selected':''}>Asset</option><option value="liability" ${d.type==='liability'?'selected':''}>Liability</option><option value="equity" ${d.type==='equity'?'selected':''}>Equity</option><option value="revenue" ${d.type==='revenue'?'selected':''}>Revenue</option><option value="expense" ${d.type==='expense'?'selected':''}>Expense</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Saldo <span class="text-red-500">*</span></label><input type="number" name="balance" value="${d.balance||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="flex items-center gap-2 cursor-pointer"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" ${d.is_active||!Object.keys(data).length?'checked':''} ${disabled} class="w-4 h-4 rounded"><span class="text-sm text-slate-700">Aktif</span></label></div>
      `;
    }
    if (res === 'stock') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Produk <span class="text-red-500">*</span></label><select name="product_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Produk</option>
          @foreach(\App\Models\Product::where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.product_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->sku }} - {{ $p->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Gudang <span class="text-red-500">*</span></label><select name="warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Gudang</option>
          @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
          <option value="{{ $w->id }}" ${Number(d.warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
          @endforeach
        </select></div>
        <div class="grid grid-cols-3 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">On Hand <span class="text-red-500">*</span></label><input type="number" min="0" step="0.001" name="on_hand" value="${d.on_hand||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Reserved</label><input type="number" min="0" step="0.001" name="reserved" value="${d.reserved||0}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Harga Rata-rata</label><input type="number" min="0" step="0.01" name="unit_cost" value="${d.unit_cost||0}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
      `;
    }
    if (res === 'stock-opnames') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="opname_date" value="${d.opname_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Gudang <span class="text-red-500">*</span></label><select name="warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Gudang</option>
          @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
          <option value="{{ $w->id }}" ${Number(d.warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="posted" ${d.status==='posted'?'selected':''}>Posted</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="3" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'stock-transfers') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="transfer_date" value="${d.transfer_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Dari Gudang <span class="text-red-500">*</span></label><select name="from_warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
            <option value="">Pilih Gudang</option>
            @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
            <option value="{{ $w->id }}" ${Number(d.from_warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
            @endforeach
          </select></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Ke Gudang <span class="text-red-500">*</span></label><select name="to_warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
            <option value="">Pilih Gudang</option>
            @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
            <option value="{{ $w->id }}" ${Number(d.to_warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
            @endforeach
          </select></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="posted" ${d.status==='posted'?'selected':''}>Posted</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="3" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'purchase-orders') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor PO <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="order_date" value="${d.order_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Supplier <span class="text-red-500">*</span></label><select name="supplier_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Supplier</option>
          @foreach(\App\Models\Partner::whereIn('type', ['supplier','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.supplier_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Gudang Tujuan <span class="text-red-500">*</span></label><select name="warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Gudang</option>
          @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
          <option value="{{ $w->id }}" ${Number(d.warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Total <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="total_amount" value="${d.total_amount||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="confirmed" ${d.status==='confirmed'?'selected':''}>Dikonfirmasi</option><option value="partial" ${d.status==='partial'?'selected':''}>Parsial</option><option value="completed" ${d.status==='completed'?'selected':''}>Selesai</option><option value="cancelled" ${d.status==='cancelled'?'selected':''}>Dibatalkan</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'goods-receipts') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="receipt_date" value="${d.receipt_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Supplier <span class="text-red-500">*</span></label><select name="supplier_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Supplier</option>
          @foreach(\App\Models\Partner::whereIn('type', ['supplier','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.supplier_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Gudang <span class="text-red-500">*</span></label><select name="warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Gudang</option>
          @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
          <option value="{{ $w->id }}" ${Number(d.warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Total Nilai <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="total_value" value="${d.total_value||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="posted" ${d.status==='posted'?'selected':''}>Posted</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'vendor-bills') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor Bill <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal Bill <span class="text-red-500">*</span></label><input type="date" name="bill_date" value="${d.bill_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Jatuh Tempo</label><input type="date" name="due_date" value="${d.due_date||''}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Supplier <span class="text-red-500">*</span></label><select name="supplier_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Supplier</option>
          @foreach(\App\Models\Partner::whereIn('type', ['supplier','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.supplier_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Total <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="total_amount" value="${d.total_amount||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Sudah Dibayar</label><input type="number" min="0" step="0.01" name="paid_amount" value="${d.paid_amount||0}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="open" ${d.status==='open'||!d.status?'selected':''}>Terbuka</option><option value="partial" ${d.status==='partial'?'selected':''}>Parsial</option><option value="paid" ${d.status==='paid'?'selected':''}>Dibayar</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'supplier-payments') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor Pembayaran <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="payment_date" value="${d.payment_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Supplier <span class="text-red-500">*</span></label><select name="supplier_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Supplier</option>
          @foreach(\App\Models\Partner::whereIn('type', ['supplier','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.supplier_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Jumlah <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="amount" value="${d.amount||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Metode <span class="text-red-500">*</span></label><select name="method" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="transfer" ${d.method==='transfer'||!d.method?'selected':''}>Transfer</option><option value="cash" ${d.method==='cash'?'selected':''}>Tunai</option><option value="check" ${d.method==='check'?'selected':''}>Cek</option></select></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="posted" ${d.status==='posted'?'selected':''}>Posted</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'sales-orders') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor SO <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="order_date" value="${d.order_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Customer <span class="text-red-500">*</span></label><select name="customer_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Customer</option>
          @foreach(\App\Models\Partner::whereIn('type', ['customer','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.customer_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Gudang Asal <span class="text-red-500">*</span></label><select name="warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Gudang</option>
          @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
          <option value="{{ $w->id }}" ${Number(d.warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Total <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="total_amount" value="${d.total_amount||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="confirmed" ${d.status==='confirmed'?'selected':''}>Dikonfirmasi</option><option value="partial" ${d.status==='partial'?'selected':''}>Parsial</option><option value="completed" ${d.status==='completed'?'selected':''}>Selesai</option><option value="cancelled" ${d.status==='cancelled'?'selected':''}>Dibatalkan</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'deliveries') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor Pengiriman <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="delivery_date" value="${d.delivery_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Customer <span class="text-red-500">*</span></label><select name="customer_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Customer</option>
          @foreach(\App\Models\Partner::whereIn('type', ['customer','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.customer_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Gudang <span class="text-red-500">*</span></label><select name="warehouse_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Gudang</option>
          @foreach(\App\Models\Warehouse::where('is_active', true)->get() as $w)
          <option value="{{ $w->id }}" ${Number(d.warehouse_id) === {{ $w->id }} ? 'selected' : ''}>{{ $w->name }}</option>
          @endforeach
        </select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Total Nilai <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="total_value" value="${d.total_value||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="posted" ${d.status==='posted'?'selected':''}>Posted</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'invoices') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor Invoice <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal Invoice <span class="text-red-500">*</span></label><input type="date" name="invoice_date" value="${d.invoice_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Jatuh Tempo</label><input type="date" name="due_date" value="${d.due_date||''}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Customer <span class="text-red-500">*</span></label><select name="customer_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Customer</option>
          @foreach(\App\Models\Partner::whereIn('type', ['customer','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.customer_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Total <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="total_amount" value="${d.total_amount||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Sudah Dibayar</label><input type="number" min="0" step="0.01" name="paid_amount" value="${d.paid_amount||0}" ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="open" ${d.status==='open'||!d.status?'selected':''}>Terbuka</option><option value="partial" ${d.status==='partial'?'selected':''}>Parsial</option><option value="paid" ${d.status==='paid'?'selected':''}>Dibayar</option><option value="overdue" ${d.status==='overdue'?'selected':''}>Jatuh Tempo</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    if (res === 'customer-payments') {
      return `
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Nomor Pembayaran <span class="text-red-500">*</span></label><input type="text" name="number" value="${d.number||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Tanggal <span class="text-red-500">*</span></label><input type="date" name="payment_date" value="${d.payment_date||''}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Customer <span class="text-red-500">*</span></label><select name="customer_id" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm">
          <option value="">Pilih Customer</option>
          @foreach(\App\Models\Partner::whereIn('type', ['customer','both'])->where('is_active', true)->get() as $p)
          <option value="{{ $p->id }}" ${Number(d.customer_id) === {{ $p->id }} ? 'selected' : ''}>{{ $p->name }}</option>
          @endforeach
        </select></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Jumlah <span class="text-red-500">*</span></label><input type="number" min="0" step="0.01" name="amount" value="${d.amount||0}" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"></div>
          <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Metode <span class="text-red-500">*</span></label><select name="method" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="transfer" ${d.method==='transfer'||!d.method?'selected':''}>Transfer</option><option value="cash" ${d.method==='cash'?'selected':''}>Tunai</option><option value="check" ${d.method==='check'?'selected':''}>Cek</option></select></div>
        </div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Status <span class="text-red-500">*</span></label><select name="status" required ${disabled} class="w-full h-9 px-3 border border-slate-200 rounded-lg text-sm"><option value="draft" ${d.status==='draft'||!d.status?'selected':''}>Draft</option><option value="posted" ${d.status==='posted'?'selected':''}>Posted</option><option value="reversed" ${d.status==='reversed'?'selected':''}>Reversed</option></select></div>
        <div><label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan</label><textarea name="notes" rows="2" ${disabled} class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm">${d.notes||''}</textarea></div>
      `;
    }
    return '';
  }

  function getViewFields(res, d) {
    const fmt = n => 'Rp ' + Number(n).toLocaleString('id-ID');
    const row = (l, v) => `<div class="grid grid-cols-3 gap-4 py-2 border-b border-slate-100"><div class="text-xs font-semibold text-slate-500 uppercase">${l}</div><div class="col-span-2 text-sm text-slate-900">${v}</div></div>`;
    if (res === 'products') return row('SKU', d.sku) + row('Nama', d.name) + row('Satuan', d.unit) + row('Harga Beli', fmt(d.purchase_price)) + row('Harga Jual', fmt(d.sale_price)) + row('Stok Min', d.min_stock) + row('Status', d.is_active ? '<span class="text-emerald-600">Aktif</span>' : '<span class="text-slate-500">Nonaktif</span>');
    if (res === 'warehouses') return row('Kode', d.code) + row('Nama', d.name) + row('Alamat', d.address || '-') + row('Telepon', d.phone || '-') + row('Status', d.is_active ? '<span class="text-emerald-600">Aktif</span>' : '<span class="text-slate-500">Nonaktif</span>');
    if (res === 'partners') return row('Kode', d.code) + row('Nama', d.name) + row('Tipe', d.type) + row('Kontak', d.contact_person || '-') + row('Telepon', d.phone || '-') + row('Email', d.email || '-') + row('Alamat', d.address || '-') + row('Status', d.is_active ? '<span class="text-emerald-600">Aktif</span>' : '<span class="text-slate-500">Nonaktif</span>');
    if (res === 'accounts') return row('Kode', d.code) + row('Nama', d.name) + row('Tipe', d.type) + row('Saldo', fmt(d.balance)) + row('Status', d.is_active ? '<span class="text-emerald-600">Aktif</span>' : '<span class="text-slate-500">Nonaktif</span>');
    if (res === 'stock') return row('Produk', d.product?.sku + ' - ' + d.product?.name) + row('Gudang', d.warehouse?.name || '-') + row('On Hand', d.on_hand) + row('Reserved', d.reserved) + row('Available', Math.max(Number(d.on_hand) - Number(d.reserved), 0)) + row('Harga Rata-rata', fmt(d.unit_cost));
    if (res === 'stock-opnames') return row('Nomor', d.number) + row('Tanggal', d.opname_date) + row('Gudang', d.warehouse?.name || '-') + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'stock-transfers') return row('Nomor', d.number) + row('Tanggal', d.transfer_date) + row('Dari', d.fromWarehouse?.name || '-') + row('Ke', d.toWarehouse?.name || '-') + row('Status', d.status);
    if (res === 'purchase-orders') return row('No. PO', d.number) + row('Tanggal', d.order_date) + row('Supplier', d.supplier?.name || '-') + row('Gudang', d.warehouse?.name || '-') + row('Total', fmt(d.total_amount)) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'goods-receipts') return row('Nomor', d.number) + row('Tanggal', d.receipt_date) + row('Supplier', d.supplier?.name || '-') + row('Gudang', d.warehouse?.name || '-') + row('Nilai', fmt(d.total_value)) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'vendor-bills') return row('No. Bill', d.number) + row('Tanggal Bill', d.bill_date) + row('Jatuh Tempo', d.due_date || '-') + row('Supplier', d.supplier?.name || '-') + row('Total', fmt(d.total_amount)) + row('Sudah Dibayar', fmt(d.paid_amount)) + row('Sisa', fmt(Math.max(Number(d.total_amount) - Number(d.paid_amount), 0))) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'supplier-payments') return row('Nomor', d.number) + row('Tanggal', d.payment_date) + row('Supplier', d.supplier?.name || '-') + row('Jumlah', fmt(d.amount)) + row('Metode', d.method) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'sales-orders') return row('No. SO', d.number) + row('Tanggal', d.order_date) + row('Customer', d.customer?.name || '-') + row('Gudang', d.warehouse?.name || '-') + row('Total', fmt(d.total_amount)) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'deliveries') return row('Nomor', d.number) + row('Tanggal', d.delivery_date) + row('No. SO', d.salesOrder?.number || '-') + row('Customer', d.customer?.name || '-') + row('Gudang', d.warehouse?.name || '-') + row('Nilai', fmt(d.total_value)) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'invoices') return row('No. Invoice', d.number) + row('Tanggal Invoice', d.invoice_date) + row('Jatuh Tempo', d.due_date || '-') + row('No. Pengiriman', d.delivery?.number || '-') + row('Customer', d.customer?.name || '-') + row('Total', fmt(d.total_amount)) + row('Sudah Dibayar', fmt(d.paid_amount)) + row('Sisa', fmt(Math.max(Number(d.total_amount) - Number(d.paid_amount), 0))) + row('Status', d.status) + row('Catatan', d.notes || '-');
    if (res === 'customer-payments') return row('Nomor', d.number) + row('Tanggal', d.payment_date) + row('No. Invoice', d.invoice?.number || '-') + row('Customer', d.customer?.name || '-') + row('Jumlah', fmt(d.amount)) + row('Metode', d.method) + row('Status', d.status) + row('Catatan', d.notes || '-');
    return '';
  }

  function submitForm(id = null) {
    const form = document.getElementById('dataForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    // ponytail: collect lines from DOM table if exists
    const linesBody = document.getElementById('linesBody');
    if (linesBody) {
      data.lines = Array.from(linesBody.querySelectorAll('tr')).map(tr => {
        const cells = tr.querySelectorAll('td');
        return {
          product_id: cells[0]?.querySelector('select')?.value || cells[0]?.dataset.productId,
          qty: parseFloat(cells[1]?.querySelector('input')?.value || cells[1]?.textContent) || 0,
          unit: cells[2]?.querySelector('input')?.value || cells[2]?.textContent || '',
          unit_price: parseFloat(cells[3]?.querySelector('input')?.value || cells[3]?.textContent) || 0,
          unit_cost: parseFloat(cells[3]?.querySelector('input')?.value || cells[3]?.textContent) || 0,
          description: cells[0]?.querySelector('input[name*="description"]')?.value || '',
          notes: cells[5]?.querySelector('input')?.value || ''
        };
      });
    }
    
    const url = id ? `${resourceBase()}/${id}` : resourceBase();
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
      method: method,
      headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
      body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(d => {
      if (d.success) {
        closeModal();
        location.reload();
      } else {
        alert(d.message || 'Gagal menyimpan data');
      }
    })
    .catch(() => alert('Terjadi kesalahan'));
  }
  
  function addLine(type) {
    const tbody = document.getElementById('linesBody');
    const tr = document.createElement('tr');
    tr.className = 'border-b border-slate-100';
    if (type === 'product') {
      tr.innerHTML = \`
        <td class="py-2 pr-2"><select class="w-full h-8 px-2 border border-slate-200 rounded text-xs" required>
          <option value="">Pilih Produk</option>
          \${PRODUCTS.map(p => \`<option value="\${p.id}">\${p.sku} - \${p.name}</option>\`).join('')}
        </select></td>
        <td class="py-2 px-2"><input type="number" step="0.001" min="0" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" value="1" onchange="calcSubtotal(this)" required></td>
        <td class="py-2 px-2"><input type="text" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" value="pcs" required></td>
        <td class="py-2 px-2"><input type="number" step="0.01" min="0" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" value="0" onchange="calcSubtotal(this)" required></td>
        <td class="py-2 px-2 text-right text-xs font-medium">0.00</td>
        <td class="py-2 pl-2"><button type="button" onclick="this.closest('tr').remove();updateTotal()" class="text-red-600 hover:text-red-800"><span class="material-symbols-outlined text-base">delete</span></button></td>
      \`;
    } else {
      tr.innerHTML = \`
        <td class="py-2 pr-2"><input type="text" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" placeholder="Deskripsi" required></td>
        <td class="py-2 px-2"><input type="number" step="0.001" min="0" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" value="1" onchange="calcSubtotal(this)"></td>
        <td class="py-2 px-2"><input type="text" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" value=""></td>
        <td class="py-2 px-2"><input type="number" step="0.01" min="0" class="w-full h-8 px-2 border border-slate-200 rounded text-xs" value="0" onchange="calcSubtotal(this)" required></td>
        <td class="py-2 px-2 text-right text-xs font-medium">0.00</td>
        <td class="py-2 pl-2"><button type="button" onclick="this.closest('tr').remove();updateTotal()" class="text-red-600 hover:text-red-800"><span class="material-symbols-outlined text-base">delete</span></button></td>
      \`;
    }
    tbody.appendChild(tr);
  }
  
  function calcSubtotal(input) {
    const tr = input.closest('tr');
    const cells = tr.querySelectorAll('td');
    const qty = parseFloat(cells[1]?.querySelector('input')?.value) || 0;
    const price = parseFloat(cells[3]?.querySelector('input')?.value) || 0;
    const subtotal = qty * price;
    cells[4].textContent = subtotal.toFixed(2);
    updateTotal();
  }
  
  function updateTotal() {
    const tbody = document.getElementById('linesBody');
    if (!tbody) return;
    const total = Array.from(tbody.querySelectorAll('tr')).reduce((sum, tr) => {
      const subtotal = parseFloat(tr.querySelector('td:nth-child(5)')?.textContent) || 0;
      return sum + subtotal;
    }, 0);
    const totalInput = document.querySelector('input[name="total_amount"], input[name="total_value"]');
    if (totalInput) totalInput.value = total.toFixed(2);
  }
  </script>

</body>
</html>
