<nav class="relative w-full max-w-full overflow-hidden bg-[#0f4c4a] border-b border-teal-800 text-white shadow-md sticky top-0 z-50">
  <div class="w-full px-4 sm:px-6 lg:px-8">
    <div class="flex min-h-16 min-w-0 flex-wrap items-center justify-between gap-3 py-2 md:flex-nowrap md:py-0">
      
      <!-- Sisi Kiri: Logo & Navigasi Utama -->
      <div class="flex min-w-0 flex-1 items-center space-x-4 lg:space-x-8">
        
        <!-- Logo / Brand -->
        <a href="{{ route('dashboard') }}" class="group flex min-w-0 items-center space-x-3 transition-transform duration-200 hover:scale-105">
          <div class="p-2 bg-amber-400/10 group-hover:bg-amber-400 border border-amber-400/30 rounded-xl transition-all duration-300">
            <svg class="w-6 h-6 text-amber-400 group-hover:text-[#0f4c4a] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 000-4z"></path>
            </svg>
          </div>
          <div class="flex min-w-0 flex-col">
            <span class="truncate font-black text-lg tracking-wider text-white uppercase group-hover:text-amber-300 transition-colors leading-tight">
              Toko Kelontong Zahir
            </span>
            <span class="truncate text-[10px] tracking-widest text-amber-300/80 font-medium uppercase leading-tight">
              Manajemen Toko
            </span>
          </div>
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-1.5 bg-teal-950/50 p-1.5 rounded-2xl border border-teal-800/60">
          
          <a href="{{ route('dashboard') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('dashboard') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
            <span>Beranda</span>
          </a>

          @if(auth()->check() && strtolower(auth()->user()->role->name) === 'admin')
          <a href="{{ route('admin.users.index') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.users.*') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
            <span>Pengguna</span>
          </a>

          <a href="{{ route('admin.history.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.history.*') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
              <span>Riwayat</span>
          </a>

          <a href="{{ route('admin.jenis.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.jenis.*') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
              <span>Jenis</span>
          </a>
          @endif

          <a href="{{ route('produk.index') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('produk.*') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
            <span>Produk</span>
          </a>

          <a href="{{ route('penjualan.index') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('penjualan.*') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
            <span>Penjualan</span>
          </a>

          <a href="{{ route('about') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('about') ? 'bg-amber-400 text-[#0f4c4a] shadow-md' : 'text-teal-100 hover:bg-teal-800/50 hover:text-white' }}">
            <span>Tentang</span>
          </a>
        
        </div>
      </div>

      <!-- Sisi Kanan: Profil & Logout -->
      <div class="flex shrink-0 items-center space-x-2 sm:space-x-3">

        <button type="button" id="mobile-menu-button" aria-controls="mobile-navigation" aria-expanded="false" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-teal-700 bg-teal-950/50 text-teal-100 transition hover:bg-teal-800 md:hidden">
          <span class="sr-only">Buka menu navigasi</span>
          <svg id="mobile-menu-open-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
          <svg id="mobile-menu-close-icon" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <div class="hidden items-center space-x-2.5 text-xs bg-teal-950/50 px-3.5 py-1.5 rounded-full border border-teal-800/60 sm:flex">
          <div class="p-1 bg-amber-400 rounded-full text-[#0f4c4a]">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          
          <span class="max-w-32 truncate font-bold text-white tracking-wide">
            {{ auth()->user()->name ?? 'Admin' }}
          </span>
          
          <span class="px-2.5 py-0.5 text-[9px] font-black uppercase bg-teal-100 text-teal-900 rounded-full shadow-sm">
            {{ is_object(auth()->user()->role) ? (auth()->user()->role->name ?? 'ADMIN') : (auth()->user()->role ?? 'ADMIN') }}
          </span>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 sm:px-4 sm:py-1.5 border border-rose-500/40 bg-rose-500/20 hover:bg-rose-600 text-rose-100 hover:text-white text-xs font-bold rounded-full transition-all duration-200 hover:shadow-md active:scale-95 focus:outline-none">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Keluar</span>
          </button>
        </form>

      </div>

    </div>

    <div id="mobile-navigation" class="hidden border-t border-teal-800/70 pb-3 pt-2 md:hidden">
      <div class="grid gap-1 rounded-2xl border border-teal-800/60 bg-teal-950/50 p-2">
        <a href="{{ route('dashboard') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Beranda</a>
        @if(auth()->check() && strtolower(auth()->user()->role->name) === 'admin')
          <a href="{{ route('admin.users.index') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('admin.users.*') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Pengguna</a>
          <a href="{{ route('admin.history.index') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('admin.history.*') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Riwayat</a>
          <a href="{{ route('admin.jenis.index') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('admin.jenis.*') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Jenis</a>
        @endif
        <a href="{{ route('produk.index') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('produk.*') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Produk</a>
        <a href="{{ route('penjualan.index') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('penjualan.*') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Penjualan</a>
        <a href="{{ route('about') }}" class="rounded-xl px-3 py-2.5 text-xs font-bold {{ request()->routeIs('about') ? 'bg-amber-400 text-[#0f4c4a]' : 'text-teal-100 hover:bg-teal-800/60 hover:text-white' }}">Tentang</a>
      </div>
    </div>
  </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileNavigation = document.getElementById('mobile-navigation');
        const openIcon = document.getElementById('mobile-menu-open-icon');
        const closeIcon = document.getElementById('mobile-menu-close-icon');

        if (!menuButton || !mobileNavigation) return;

        menuButton.addEventListener('click', () => {
            const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', String(!isOpen));
            mobileNavigation.classList.toggle('hidden', isOpen);
            openIcon.classList.toggle('hidden', !isOpen);
            closeIcon.classList.toggle('hidden', isOpen);
        });
    });
</script>