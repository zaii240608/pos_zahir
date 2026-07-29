<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Dashboard Overview - POS')

<!-- batas awal isi konten -->
@section('content')

    <!-- Memanggil Navbar -->
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Header Dashboard & Tanggal Hari Ini -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Dashboard Overview</h1>
                    <p class="text-xs text-stone-500 mt-1">Pantau performa penjualan dan status inventaris toko kamu secara real-time.</p>
                </div>
                
                <!-- Tanggal Hari Ini dari Controller ($tanggalHariIni) -->
                <div class="inline-flex items-center gap-2.5 bg-stone-50 px-4 py-2.5 rounded-2xl border border-stone-200/80 text-stone-700 font-bold text-xs self-start md:self-auto">
                    <div class="p-1.5 bg-teal-100/70 text-teal-700 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span>{{ isset($tanggalHariIni) ? $tanggalHariIni->translatedFormat('l, d F Y') : \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            @if(auth()->check() && strtolower(auth()->user()->role->name) === 'admin')

                <!-- SECTION 1: TODAY'S SALES -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-1.5 h-6 bg-teal-600 rounded-full"></div>
                        <h2 class="text-lg font-extrabold text-stone-800 tracking-tight">Penjualan Hari Ini</h2>
                    </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Nilai Penjualan Hari ini -->
                        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider">Total Penjualan Hari Ini</p>
                                    <h3 class="text-3xl font-black text-teal-700 mt-2 tracking-tight">
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

                        <!-- Jumlah Transaksi Hari ini -->
                        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider">Jumlah Transaksi Hari Ini</p>
                                    <h3 class="text-3xl font-black text-stone-900 mt-2 tracking-tight">
                                        {{ $ringkasan['total_transaksi'] ?? 0 }} <span class="text-base font-bold text-stone-500">Transaksi</span>
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-stone-100 text-stone-700 rounded-2xl border border-stone-200/60">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: CASH & PAYMENT STATUS -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pl-1">
                        <div class="w-1.5 h-6 bg-teal-600 rounded-full"></div>
                        <h2 class="text-lg font-extrabold text-stone-800 tracking-tight">Status Metode Pembayaran</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Pembayaran Tunai -->
                        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider">Pembayaran Tunai (Cash)</p>
                                    <h3 class="text-3xl font-black text-stone-900 mt-2 tracking-tight">
                                        Rp {{ number_format($ringkasan['total_cash'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-amber-50 text-amber-700 rounded-2xl border border-amber-100">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pembayaran Non-Tunai -->
                        <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm hover:shadow-md transition duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider">Pembayaran Non-Tunai (QRIS/Transfer)</p>
                                    <h3 class="text-3xl font-black text-stone-900 mt-2 tracking-tight">
                                        Rp {{ number_format($ringkasan['total_non_tunai'] ?? 0, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-2xl border border-indigo-100">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            <!-- SECTION 3: TOP SELLING PRODUCTS -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pl-1">
                    <div class="w-1.5 h-6 bg-teal-600 rounded-full"></div>
                    <h2 class="text-lg font-extrabold text-stone-800 tracking-tight">Produk Terlaris Hari Ini</h2>
                </div>

                <!-- Card Utama Produk Terlaris -->
                <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                    <div class="space-y-3">
                        @forelse ($produkTerlaris as $item)
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-stone-50/80 border border-stone-100 hover:bg-stone-100/70 transition duration-150">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-black text-xs border border-teal-200/60">
                                        #{{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-stone-900 text-xs sm:text-sm">{{ $item->nama }}</h4>
                                        <p class="text-[11px] text-stone-500 mt-0.5">
                                            Sisa Stok: <span class="font-bold text-stone-700">{{ $item->stok }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 text-[11px] font-extrabold text-teal-800 bg-teal-50 border border-teal-200/60 rounded-full">
                                        {{ number_format($item->total_terjual) }} Terjual
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-stone-400 font-medium text-xs">
                                <svg class="w-10 h-10 mx-auto mb-2 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                Belum ada transaksi tercatat hari ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- SECTION 4: CRITICAL INVENTORY STATUS -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 pl-1">
                    <div class="w-1.5 h-6 bg-rose-500 rounded-full"></div>
                    <h2 class="text-lg font-extrabold text-stone-800 tracking-tight">Peringatan Stok</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Daftar Produk Stok Rendah -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-sm font-extrabold text-stone-800">Stok Menipis</h3>
                                <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200/60 text-[10px] font-extrabold uppercase tracking-wider rounded-full">Peringatan</span>
                            </div>
                            
                            <div class="divide-y divide-stone-100">
                                @forelse($produkStokRendah as $item)
                                    <div class="flex justify-between items-center py-3">
                                        <span class="text-xs font-bold text-stone-700">{{ $item->nama }}</span>
                                        <span class="text-xs font-extrabold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-xl border border-amber-200/50">
                                            Sisa: {{ $item->stok }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-xs text-stone-400 py-6 text-center font-medium">Semua stok produk dalam kondisi aman.</p>
                                @endforelse
                            </div>
                        </div>

                        @if(method_exists($produkStokRendah, 'links'))
                            <div class="mt-4 pt-4 border-t border-stone-100">
                                {{ $produkStokRendah->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Produk Habis Stok -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-sm font-extrabold text-stone-800">Stok Habis</h3>
                                <span class="px-3 py-1 bg-rose-50 text-rose-800 border border-rose-200/60 text-[10px] font-extrabold uppercase tracking-wider rounded-full">Kritis</span>
                            </div>

                            <div class="divide-y divide-stone-100">
                                @forelse($produkStokHabis as $item)
                                    <div class="flex justify-between items-center py-3">
                                        <span class="text-xs font-bold text-stone-700">{{ $item->nama }}</span>
                                        <span class="text-xs font-extrabold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-xl border border-rose-200/50">
                                            Stok: {{ $item->stok }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-xs text-stone-400 py-6 text-center font-medium">Tidak ada produk yang habis stok.</p>
                                @endforelse
                            </div>
                        </div>

                        @if(method_exists($produkStokHabis, 'links'))
                            <div class="mt-4 pt-4 border-t border-stone-100">
                                {{ $produkStokHabis->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

<!-- batas Akhir isi konten -->
@endsection