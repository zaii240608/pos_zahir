@extends('layouts.app')

@section('title', 'Manajemen User - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Kelola Pengguna</h1>
                    <p class="text-xs text-stone-500 mt-1">Kelola data pengguna dan hak akses akun dalam sistem POS</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <!-- Form Search -->
                    <form action="{{ route('admin.users.index') }}" method="GET" class="relative flex-1 sm:w-64">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari user..." 
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-stone-50 border border-stone-200 rounded-2xl text-xs font-medium text-stone-900 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:bg-white transition"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </form>

                    <!-- Tombol Tambah User -->
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center justify-center gap-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-extrabold px-5 py-2.5 rounded-2xl shadow-sm hover:shadow transition active:scale-95 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Pengguna</span>
                    </a>
                </div>
            </div>

            <!-- Notifikasi Alert Section -->
            @if(session('warning'))
                <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200/80 flex items-start sm:items-center gap-3 text-amber-800 text-xs font-medium shadow-xs transition">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-1">
                        <span class="font-bold">Peringatan:</span> {{ session('warning') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 flex items-start sm:items-center gap-3 text-rose-800 text-xs font-medium shadow-xs transition">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <span class="font-bold">Gagal:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start sm:items-center gap-3 text-emerald-800 text-xs font-medium shadow-xs transition">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div class="flex-1">
                        <span class="font-bold">Berhasil!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Tabel Data User -->
            <div class="bg-white shadow-sm rounded-3xl overflow-hidden border border-stone-200/80">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-stone-600">
                        <thead class="bg-stone-50/80 border-b border-stone-200/80 text-[11px] uppercase font-extrabold text-stone-500 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center w-16">#</th>
                                <th scope="col" class="px-6 py-4">Nama Pengguna</th>
                                <th scope="col" class="px-6 py-4">Alamat Email</th>
                                <th scope="col" class="px-6 py-4">Role / Hak Akses</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 font-medium">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-stone-50/60 transition-colors">
                                    <td class="px-6 py-4 text-center font-bold text-stone-400">
                                        {{ $users->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-stone-900">
                                        {{ $user->name }}
                                        @if(auth()->id() === $user->id)
                                            <span class="ml-1.5 px-2 py-0.5 text-[10px] font-bold bg-teal-50 text-teal-700 rounded-full border border-teal-200">Anda</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-stone-600">
                                        {{ $user->email }}
                                    </td>
                                    <!-- Role teks biasa tanpa gaya badge tombol -->
                                    <td class="px-6 py-4 font-bold text-stone-700 uppercase tracking-wide">
                                        {{ $user->role->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Edit (Kuning) -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="px-4 py-1.5 bg-amber-100/70 hover:bg-amber-200 text-amber-900 font-bold rounded-full border border-amber-300/50 transition shadow-xs active:scale-95">
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus (Merah Muda/Pink) -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="delete-user-form-{{ $user->id }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('delete-user-form-{{ $user->id }}', 'Apakah Anda yakin ingin menghapus user {{ $user->name }}?')" 
                                                        class="px-4 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-full border border-rose-200 transition shadow-xs active:scale-95">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-stone-400 font-medium">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        Data pengguna tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                @if($users->hasPages())
                    <div class="px-6 py-4 bg-stone-50/50 border-t border-stone-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection