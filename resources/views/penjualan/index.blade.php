@extends('layouts.app')
@section('title', 'Daftar Penjualan - POS')
@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-teal-50 border border-teal-200 text-teal-800 px-5 py-4 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Header Halaman & Tombol Buat Transaksi -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Daftar Transaksi Penjualan</h1>
                    <p class="text-xs text-stone-500 mt-1">Kelola dan pantau seluruh riwayat transaksi kasir Anda secara realtime.</p>
                </div>
                
                <div>
                    <a href="{{ route('penjualan.create') }}" 
                       class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-extrabold px-5 py-2.5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 text-sm active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Transaksi Baru</span>
                    </a>
                </div>
            </div>

            <!-- Form Cari Penjualan -->
            <div class="mb-6">
                <form action="{{ route('penjualan.index') }}" method="GET" class="flex gap-2">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari transaksi anda..." 
                               class="w-full bg-white border border-stone-200 text-stone-800 placeholder-stone-400 rounded-2xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 shadow-sm transition">
                    </div>
                    <button type="submit" class="bg-stone-900 hover:bg-black text-amber-400 px-6 py-2.5 rounded-2xl text-sm font-extrabold shadow-sm transition-all active:scale-95 shrink-0">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Penjualan -->
            <div class="bg-white shadow-sm rounded-3xl border border-stone-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-stone-50 border-b border-stone-200/80 text-stone-700">
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">#</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Tanggal Transaksi</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Kasir</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Total Pembayaran</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Metode</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Status</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($sales as $index => $sale)
                                <tr class="hover:bg-stone-50/80 transition-colors">
                                    <td class="p-4 text-stone-800 font-bold">
                                        {{ $sales->firstItem() + $index }}
                                    </td>
                                    <td class="p-4 text-stone-600 font-medium whitespace-nowrap">
                                        {{ $sale->created_at ? $sale->created_at->format('d-m-Y H:i:s') : '-' }}
                                    </td>
                                    <td class="p-4 text-stone-800 font-bold">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-teal-100 text-teal-900 flex items-center justify-center text-xs font-black">
                                                {{ strtoupper(substr($sale->user->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <span>{{ $sale->user->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-teal-900 font-black whitespace-nowrap">
                                        Rp {{ number_format($sale->total_pembayaran ?? $sale->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-900 border border-amber-200 font-bold uppercase text-[10px] rounded-full tracking-wider">
                                            {{ $sale->metode_pembayaran ?? 'CASH' }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if($sale->status == 'COMPLETED')
                                            <span class="px-3 py-1 text-[11px] font-extrabold rounded-full bg-emerald-100 text-emerald-900 border border-emerald-200 inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Selesai
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-[11px] font-extrabold rounded-full bg-amber-100 text-amber-900 border border-amber-200 inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span> {{ $sale->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('penjualan.show', $sale->id) }}" 
                                               class="bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold px-3 py-1.5 rounded-xl border border-stone-200 transition active:scale-95">
                                                Detail
                                            </a>

                                            <!-- Tombol Edit -->
                                            @can('update', $sale)
                                            <a href="{{ route('penjualan.edit', $sale->id) }}" 
                                               class="bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold px-3 py-1.5 rounded-xl border border-amber-200 transition active:scale-95">
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
                                                        class="bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-800 border border-rose-200 text-xs font-bold px-3 py-1.5 rounded-xl transition active:scale-95">
                                                    Hapus
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-stone-400 py-12 text-sm">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-10 h-10 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <span>Belum ada data penjualan.</span>
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
                {{ $sales->links() }}
            </div>

        </div>
    </div>
@endsection