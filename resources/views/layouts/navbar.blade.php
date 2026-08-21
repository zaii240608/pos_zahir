<nav class="w-full bg-gradient-to-r from-teal-900 via-teal-800 to-teal-900 border-b border-teal-700/50 text-white shadow-md sticky top-0 z-50 backdrop-blur-md">
  <div class="w-full px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 gap-4">
      
      <!-- Sisi Kiri: Logo & Navigasi Utama -->
      <div class="flex items-center space-x-8">
        
        <!-- Logo / Brand -->
        <a href="{{ route('dashboard') }}" class="group flex items-center space-x-3 transition-transform duration-200 hover:scale-105">
          <div class="p-2 bg-amber-400/10 group-hover:bg-amber-400 border border-amber-400/30 rounded-xl transition-all duration-300 shadow-inner">
            <svg class="w-6 h-6 text-amber-400 group-hover:text-teal-950 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 000-4z"></path>
            </svg>
          </div>
          <div class="flex flex-col">
            <span class="font-extrabold text-lg tracking-wider text-white uppercase group-hover:text-amber-300 transition-colors leading-tight">
              Sistem POS
            </span>
            <span class="text-[10px] tracking-widest text-amber-300/80 font-medium uppercase leading-tight">
              Aplikasi Kasir
            </span>
          </div>
        </a>

        <div class="hidden md:flex items-center space-x-1.5 bg-teal-950/40 p-1.5 rounded-2xl border border-teal-700/40">
          
          <!-- Beranda -->
          <a href="{{ route('dashboard') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('dashboard') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
            <span>Beranda</span>
          </a>

          @if(auth()->check() && strtolower(auth()->user()->role->name) === 'admin')
          <!-- Pengguna -->
          <a href="{{ route('admin.users.index') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.users.*') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
            <span>Pengguna</span>
          </a>

          <!-- Riwayat -->
          <a href="{{ route('admin.history.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.history.*') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
              <span>Riwayat</span>
          </a>

          <!-- Jenis -->
          <a href="{{ route('admin.jenis.index') }}" 
            class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('admin.jenis.*') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
              <span>Jenis</span>
          </a>
          @endif

          <!-- Produk -->
          <a href="{{ route('produk.index') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('produk.*') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
            <span>Produk</span>
          </a>

          <!-- Penjualan -->
          <a href="{{ route('penjualan.index') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('penjualan.*') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
            <span>Penjualan</span>
          </a>

          <!-- Tentang -->
          <a href="{{ route('about') }}" 
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('about') ? 'bg-amber-400 text-teal-950 shadow-md scale-105' : 'text-teal-100 hover:bg-teal-700/50 hover:text-white' }}">
            <span>Tentang</span>
          </a>
        
        </div>
      </div>

      <!-- Sisi Kanan: Profil Pengguna & Logout -->
      <div class="flex items-center space-x-3 shrink-0">

        <!-- Badge Info Pengguna -->
        <div class="flex items-center space-x-2.5 text-xs bg-stone-900/30 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-teal-700/50 shadow-inner">
          <div class="p-1 bg-amber-400 rounded-full text-teal-950 shadow">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          
          <span class="font-bold text-white tracking-wide">
            {{ auth()->user()->name ?? 'Admin' }}
          </span>
          
          <span class="px-2.5 py-0.5 text-[9px] font-black uppercase bg-stone-100 text-teal-950 rounded-full shadow-sm">
            {{ is_object(auth()->user()->role) ? (auth()->user()->role->name ?? 'ADMIN') : (auth()->user()->role ?? 'ADMIN') }}
          </span>
        </div>

        <!-- Tombol Logout (Bahasa Inggris) -->
        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 border border-rose-500/40 bg-rose-500/20 hover:bg-rose-600 text-rose-100 hover:text-white text-xs font-bold rounded-full transition-all duration-200 hover:shadow-md hover:scale-105 active:scale-95 focus:outline-none">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Keluar</span>
          </button>
        </form>

      </div>

    </div>
  </div>
</nav>