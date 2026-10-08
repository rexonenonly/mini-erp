<!DOCTYPE html><html lang="id"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk ke MiniERP - PT Distribusi Mandiri Utama</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config={theme:{extend:{fontFamily:{sans:['Inter','system-ui','sans-serif'],mono:['JetBrains Mono','ui-monospace','monospace']},colors:{brand:{DEFAULT:'#135bec',hover:'#0e4ac7',light:'#eff4ff',dark:'#0f172a'}}}}}</script>
  <style>body{font-family:'Inter',system-ui,-apple-system,BlinkMacSystemFont,sans-serif;-webkit-font-smoothing:antialiased}</style>
</head>
<body class="bg-[#f8f9ff] text-[#0b1c30] min-h-screen flex flex-col justify-between selection:bg-[#135bec] selection:text-white">
  <header class="w-full h-14 bg-white border-b border-[#e2e8f0] px-6 lg:px-12 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-8 h-8 rounded bg-[#135bec] text-white flex items-center justify-center font-bold text-base shadow-sm">M</div>
      <div class="flex flex-col"><span class="font-bold text-[15px] text-[#0f172a] leading-none">MiniERP</span><span class="text-[11px] text-[#64748b] font-medium leading-tight mt-0.5">PT Distribusi Mandiri Utama</span></div>
    </div>
    <div class="flex items-center gap-4 text-xs font-medium text-[#64748b]">
      <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#f1f5f9] text-[#334155]"><span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span><span>Sistem Operasional Normal</span></div>
      <a href="#" class="hover:text-[#135bec] transition-colors flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">help</span><span>Bantuan &amp; Dukungan</span></a>
    </div>
  </header>
  <main class="flex-1 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-[420px]">
      <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06)] p-8">
        <div class="mb-6"><div class="text-center"><h1 class="text-2xl font-bold text-[#0f172a] tracking-tight">MiniERP</h1><p class="text-xs text-[#64748b] mt-1">Masuk Akun</p></div></div>
        @if($errors->any())
          <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif
        @if(session('status'))
          <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
          @csrf
          <div>
            <label for="email" class="block text-xs font-semibold text-[#334155] uppercase tracking-wider mb-1.5">Nama Pengguna atau Email</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-2.5 text-[#94a3b8] text-[18px] pointer-events-none">person</span>
              <input type="text" id="email" name="email" value="{{ old('email') }}" required class="w-full h-10 pl-9 pr-3 text-sm bg-white border border-[#cbd5e1] rounded-lg text-[#0f172a] placeholder:text-[#94a3b8] focus:outline-none focus:border-[#135bec] focus:ring-1 focus:ring-[#135bec] transition-all" placeholder="nama@minierp.test">
            </div>
          </div>
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="password" class="block text-xs font-semibold text-[#334155] uppercase tracking-wider">Kata Sandi</label>
              <a href="#" class="text-xs text-[#135bec] hover:underline font-medium">Lupa sandi?</a>
            </div>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-2.5 text-[#94a3b8] text-[18px] pointer-events-none">key</span>
              <input type="password" id="password" name="password" required class="w-full h-10 pl-9 pr-10 text-sm bg-white border border-[#cbd5e1] rounded-lg text-[#0f172a] placeholder:text-[#94a3b8] focus:outline-none focus:border-[#135bec] focus:ring-1 focus:ring-[#135bec] transition-all" placeholder="••••••••">
              <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-2.5 text-[#94a3b8] hover:text-[#475569] transition-colors" title="Tampilkan / Sembunyikan"><span class="material-symbols-outlined text-[18px]" id="eyeIcon">visibility</span></button>
            </div>
          </div>
          <div class="pt-2">
            <button type="submit" class="w-full h-10 bg-[#135bec] hover:bg-[#0e4ac7] active:bg-[#0c3ea8] text-white rounded-lg font-semibold text-sm flex items-center justify-center gap-2 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-[#135bec] focus:ring-offset-2">
              <span>Masuk ke Dashboard</span><span class="material-symbols-outlined text-[18px]">login</span>
            </button>
          </div>
        </form>
      </div>
      <div class="mt-6 text-center text-xs text-[#64748b] space-y-1">
        <div class="flex items-center justify-center gap-2">
          <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-[#10b981]">verified_user</span><span>Enkripsi TLS 1.3</span></span><span>•</span><span>Sesi Terisolasi</span><span>•</span><span>Audit Log Aktif</span>
        </div>
        <p class="text-[11px] text-[#94a3b8]">© 2026 PT Distribusi Mandiri Utama. Seluruh hak cipta dilindungi.</p>
      </div>
    </div>
  </main>
  <footer class="w-full py-3 px-6 text-center border-t border-[#e2e8f0] bg-white text-[11px] text-[#64748b] flex flex-col sm:flex-row items-center justify-between gap-2">
    <div><span>Periode Akuntansi Berjalan: </span><span class="font-semibold text-[#0f172a]">Oktober 2026</span><span class="ml-1.5 px-1.5 py-0.2 rounded font-mono text-[10px] bg-[#dcfce7] text-[#15803d] font-bold">OPEN</span></div>
    <div class="flex items-center gap-4"><a href="#" class="hover:underline">Kebijakan Privasi</a><a href="#" class="hover:underline">Ketentuan Layanan</a><a href="#" class="hover:underline">Status Server</a></div>
  </footer>
  <script>
    function togglePasswordVisibility(){
      const p=document.getElementById('password'),e=document.getElementById('eyeIcon');
      if(p.type==='password'){p.type='text';e.textContent='visibility_off';}else{p.type='password';e.textContent='visibility';}
    }
  </script>
</body></html>
