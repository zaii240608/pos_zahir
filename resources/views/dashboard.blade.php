@extends('layouts.app')

@section('title', 'Dashboard Overview - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-teal-900/10 shadow-sm shadow-teal-900/5 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-xl border border-teal-500/20 hidden sm:block">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Beranda</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Pantau performa penjualan dan status inventaris toko kamu secara real-time.</p>
                    </div>
                </div>
                
                <div class="inline-flex items-center gap-2.5 bg-teal-50/60 px-4 py-2.5 rounded-xl border border-teal-200/80 text-teal-900 font-bold text-xs self-start md:self-auto shadow-sm">
                    <div class="p-1.5 bg-teal-600 text-white rounded-lg shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span>{{ isset($tanggalHariIni) ? $tanggalHariIni->translatedFormat('l, d F Y') : \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            @if(auth()->check() && strtolower(auth()->user()->role->name) === 'admin')

                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-2 h-6 bg-teal-600 rounded-full shadow-sm"></div>
                        <h2 class="text-lg font-black text-slate-800 tracking-tight">Penjualan Hari Ini</h2>
                    </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all"></div>
                            <div class="flex items-center justify-between relative z-10">
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Penjualan Hari Ini</p>
                                    <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">
                                        Rp {{ number_format($ringkasan['total_penjualan'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-teal-50 text-teal-700 rounded-2xl border border-teal-100">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Jumlah Transaksi Hari Ini</p>
                                    <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">
                                        {{ $ringkasan['total_transaksi'] ?? 0 }} <span class="text-base font-bold text-teal-600">Transaksi</span>
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-teal-50 text-teal-700 rounded-2xl border border-teal-100">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-2 h-6 bg-amber-500 rounded-full shadow-sm"></div>
                        <h2 class="text-lg font-black text-slate-800 tracking-tight">Status Metode Pembayaran</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-2xl border-l-4 border-l-amber-500 border-t border-r border-b border-slate-200/80 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-amber-600 uppercase tracking-wider">Pembayaran Tunai (Cash)</p>
                                    <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">
                                        Rp {{ number_format($ringkasan['total_cash'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-amber-50 text-amber-600 rounded-2xl border border-amber-200/60 shadow-sm">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl border-l-4 border-l-teal-500 border-t border-r border-b border-slate-200/80 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-teal-600 uppercase tracking-wider">Pembayaran Non-Tunai (QRIS/Transfer)</p>
                                    <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">
                                        Rp {{ number_format($ringkasan['total_non_tunai'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-teal-50 text-teal-600 rounded-2xl border border-teal-200/60 shadow-sm">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pl-1">
                    <div class="w-2 h-6 bg-amber-500 rounded-full shadow-sm"></div>
                    <h2 class="text-lg font-black text-slate-800 tracking-tight">Produk Terlaris Hari Ini</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="space-y-3">
                        @forelse ($produkTerlaris as $item)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-teal-200 hover:bg-teal-50/30 transition duration-150 group">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-black text-xs shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform">
                                        #{{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-teal-700 transition-colors">{{ $item->nama }}</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">
                                            Sisa Stok: <span class="font-bold text-slate-700">{{ $item->stok }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3.5 py-1.5 text-[11px] font-extrabold text-teal-800 bg-teal-100/70 border border-teal-200 rounded-xl shadow-xs">
                                        {{ number_format($item->total_terjual) }} Terjual
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 font-medium text-xs">
                                <div class="w-12 h-12 mx-auto mb-3 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                Belum ada transaksi tercatat hari ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pl-1">
                    <div class="w-2 h-6 bg-rose-500 rounded-full shadow-sm"></div>
                    <h2 class="text-lg font-black text-slate-800 tracking-tight">Peringatan Stok</h2>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <h3 class="text-sm font-extrabold text-slate-800">Stok Menipis</h3>
                                </div>
                                <span class="px-3 py-1 bg-amber-100/70 text-amber-800 border border-amber-200 text-[10px] font-black uppercase tracking-wider rounded-lg">Peringatan</span>
                            </div>
                            
                            <div class="divide-y divide-slate-100">
                                @forelse($produkStokRendah as $item)
                                    <div class="flex justify-between items-center py-3 hover:bg-slate-50/80 px-2 rounded-lg transition-colors">
                                        <span class="text-xs font-bold text-slate-700">{{ $item->nama }}</span>
                                        <span class="text-xs font-extrabold text-amber-800 bg-amber-50 px-3 py-1 rounded-xl border border-amber-200/60">
                                            Sisa: {{ $item->stok }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 py-6 text-center font-medium">Semua stok produk dalam kondisi aman.</p>
                                @endforelse
                            </div>
                        </div>

                        @if(method_exists($produkStokRendah, 'links'))
                            <div class="mt-4 pt-4 border-t border-slate-100">
                                {{ $produkStokRendah->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection