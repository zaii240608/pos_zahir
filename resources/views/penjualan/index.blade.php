@extends('layouts.app')

@section('title', 'Daftar Penjualan - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div class="flex items-center gap-3 bg-teal-500/10 border border-teal-500/20 text-teal-800 px-5 py-4 rounded-2xl shadow-xs">
                    <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 bg-rose-500/10 border border-rose-500/20 text-rose-800 px-5 py-4 rounded-2xl shadow-xs">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Clean Header Card (Diisikan Judul, Input Cari, & Tombol Transaksi Baru sesuai referensi) -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                
                <!-- Sisi Kiri: Icon Box + Title + Subtitle -->
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Transaksi Penjualan</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Kelola dan pantau seluruh riwayat transaksi kasir Anda secara realtime.</p>
                    </div>
                </div>

                <!-- Sisi Kanan: Input Cari + Tombol Tambah Transaksi -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <form action="{{ route('penjualan.index') }}" method="GET" class="flex items-center gap-2">
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari transaksi..." 
                                   class="w-full bg-slate-50/80 border border-slate-200 text-slate-800 placeholder-slate-400 rounded-2xl pl-10 pr-4 py-2.5 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                        </div>

                        @if(request('search'))
                            <a href="{{ route('penjualan.index') }}" 
                               class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2.5 rounded-2xl text-xs font-bold transition-all border border-slate-200/80 shrink-0">
                                Reset
                            </a>
                        @endif
                    </form>

                    <a href="{{ route('penjualan.create') }}" 
                       class="inline-flex items-center justify-center gap-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-sm hover:shadow transition-all duration-200 active:scale-95 border border-amber-300">
                        <span>Transaksi Baru</span>
                    </a>
                </div>

            </div>

            <!-- Tabel Daftar Penjualan -->
            <div class="bg-white shadow-xs rounded-3xl border border-slate-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-[820px] w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-slate-700">
                                <th class="p-4 font-black uppercase tracking-wider">#</th>
                                <th class="p-4 font-black uppercase tracking-wider">Tanggal Transaksi</th>
                                <th class="p-4 font-black uppercase tracking-wider">Kasir</th>
                                <th class="p-4 font-black uppercase tracking-wider">Total Pembayaran</th>
                                <th class="p-4 font-black uppercase tracking-wider">Metode</th>
                                <th class="p-4 font-black uppercase tracking-wider">Status</th>
                                <th class="p-4 font-black uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($sales as $index => $sale)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 text-slate-800 font-bold">
                                        {{ $sales->firstItem() + $index }}
                                    </td>
                                    <td class="p-4 text-slate-600 font-medium whitespace-nowrap">
                                        {{ $sale->created_at ? $sale->created_at->format('d-m-Y H:i:s') : '-' }}
                                    </td>
                                    <td class="p-4 text-slate-800 font-bold">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-teal-500/10 text-teal-700 border border-teal-500/20 flex items-center justify-center text-xs font-black shrink-0">
                                                {{ strtoupper(substr($sale->user->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <span class="truncate max-w-[120px]">{{ $sale->user->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 font-black whitespace-nowrap">
                                        Rp {{ number_format($sale->total_pembayaran ?? $sale->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                            {{ $sale->metode_pembayaran ?? 'CASH' }}
                                    </td>
                                    <td class="p-4">
                                        @if($sale->status == 'COMPLETED')
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Selesai
                                        @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span> {{ $sale->status }}
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('penjualan.show', $sale->id) }}" 
                                               class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-200/80 transition active:scale-95">
                                                Detail
                                            </a>

                                            <!-- Tombol Edit -->
                                            @can('update', $sale)
                                            <a href="{{ route('penjualan.edit', $sale->id) }}" 
                                               class="bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold px-3 py-1.5 rounded-xl border border-amber-300 transition active:scale-95">
                                                Edit
                                            </a>
                                            @endcan

                                            <!-- Tombol Hapus -->
                                            @can('delete', $sale)
                                            <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" id="delete-sale-form-{{ $sale->id }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('delete-sale-form-{{ $sale->id }}', 'Apakah Anda yakin ingin menghapus data penjualan ini?')" 
                                                        class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-700 border border-rose-500/20 text-xs font-bold px-3 py-1.5 rounded-xl transition active:scale-95">
                                                    Hapus
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-slate-400 py-12 text-xs">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <span class="font-bold">Belum ada data penjualan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $sales->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
@endsection