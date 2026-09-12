@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Toko Kelontong Zahir')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 bg-white p-6 rounded-2xl border border-teal-900/10 shadow-sm shadow-teal-900/5">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-xl border border-teal-500/20 hidden sm:block">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kelola Pengguna</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Kelola data pengguna dan hak akses akun toko kelontong</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <!-- Form Input Live Search -->
                    <div class="relative flex-1 sm:w-64">
                        <input 
                            type="text" 
                            id="search-input"
                            name="search" 
                            placeholder="Cari user..." 
                            value="{{ request('search') }}"
                            autocomplete="off"
                            class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <!-- Indicator Loading / Spinner -->
                        <div id="search-spinner" class="absolute inset-y-0 right-0 pr-3.5 flex items-center hidden">
                            <svg class="animate-spin h-4 w-4 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Tombol Tambah User -->
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center justify-center gap-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-sm hover:shadow transition-all duration-200 active:scale-95 border border-amber-300">
                        <span>Tambah Pengguna</span>
                    </a>
                </div>
            </div>

            <!-- Alert Flash Session -->
            @if(session('warning'))
                <div data-auto-dismiss class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-start sm:items-center gap-3 text-amber-900 text-xs font-medium shadow-xs transition">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-1">
                        <span class="font-extrabold">Peringatan:</span> {{ session('warning') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div data-auto-dismiss class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 flex items-start sm:items-center gap-3 text-rose-900 text-xs font-medium shadow-xs transition">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <span class="font-extrabold">Gagal:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div data-auto-dismiss class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 flex items-start sm:items-center gap-3 text-teal-900 text-xs font-medium shadow-xs transition">
                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div class="flex-1">
                        <span class="font-extrabold">Berhasil!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Container Tabel Data User -->
            <div id="users-table-container" class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200/80">
                @include('users.partials.table')
            </div>

        </div>
    </div>

    <!-- Script Live Search JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const tableContainer = document.getElementById('users-table-container');
            const searchSpinner = document.getElementById('search-spinner');
            let debounceTimer;

            function fetchUsers(url) {
                searchSpinner.classList.remove('hidden');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    searchSpinner.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    searchSpinner.classList.add('hidden');
                });
            }

            // Realtime search saat mengetik
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const query = searchInput.value;
                    const url = `{{ route('admin.users.index') }}?search=${encodeURIComponent(query)}`;
                    
                    window.history.pushState({ path: url }, '', url);
                    fetchUsers(url);
                }, 100);
            });

            // Pagination klik tanpa reload
            tableContainer.addEventListener('click', function (e) {
                const link = e.target.closest('.pagination-wrapper a');
                if (link) {
                    e.preventDefault();
                    const url = link.getAttribute('href');
                    window.history.pushState({ path: url }, '', url);
                    fetchUsers(url);
                }
            });

            // Back/Forward browser
            window.addEventListener('popstate', function () {
                fetchUsers(window.location.href);
            });
        });
    </script>
@endsection