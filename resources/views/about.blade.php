@extends('layouts.app')

@section('title', 'Tentang Aplikasi - POS')

@section('content')

    <!-- Memanggil Navbar -->
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero Section -->
            <div class="bg-[#0f4c4a] text-white rounded-3xl p-8 md:p-10 shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-3 z-10 max-w-2xl">
                    <span class="bg-amber-400 text-[#0f4c4a] text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full">
                        Versi 1.0.0
                    </span>
                    <h2 class="text-3xl md:text-4xl font-black tracking-tight">Solusi Kasir & Manajemen Stok Modern</h2>
                    <p class="text-teal-100 text-xs md:text-sm font-normal leading-relaxed">
                        Sistem Point of Sale (POS) intuitif yang dirancang untuk mempercepat proses transaksi, memantau riwayat penjualan, dan mengelola inventaris toko secara real-time.
                    </p>
                </div>
                <div class="z-10 shrink-0">
                    <div class="w-24 h-24 bg-amber-400/20 backdrop-blur-md rounded-3xl border border-amber-400/30 flex items-center justify-center text-amber-400 shadow-2xl">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-teal-800/40 rounded-full blur-2xl pointer-events-none"></div>
            </div>

            <!-- Grid Fitur Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl p-6 border border-stone-200/80 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-50 text-[#0f4c4a] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-extrabold text-stone-800 text-sm">Kasir & Multi Pembayaran</h3>
                    <p class="text-stone-500 text-xs leading-relaxed">
                        Dukungan fleksibel untuk berbagai metode transaksi tunai (Cash), QRIS, maupun Transfer Bank.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-stone-200/80 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="font-extrabold text-stone-800 text-sm">Sistem Hold Stock (Draft)</h3>
                    <p class="text-stone-500 text-xs leading-relaxed">
                        Fitur penahanan stok sementara secara akurat saat transaksi berada dalam status OPEN atau draft.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-stone-200/80 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-50 text-[#0f4c4a] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="font-extrabold text-stone-800 text-sm">Pantau Riwayat Realtime</h3>
                    <p class="text-stone-500 text-xs leading-relaxed">
                        Rekap laporan transaksi kasir yang tercatat akurat untuk mempermudah monitoring harian.
                    </p>
                </div>
            </div>

            <!-- Info Sistem Card -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-stone-200/80 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-1">
                    <h4 class="font-black text-stone-800 text-base">Informasi Sistem</h4>
                    <p class="text-xs text-stone-500 font-medium">Dikembangkan menggunakan Laravel & Tailwind CSS.</p>
                </div>
                <div class="flex items-center space-x-6 text-xs text-stone-600 font-bold border-t md:border-t-0 md:border-l border-stone-100 pt-4 md:pt-0 md:pl-8 w-full md:w-auto">
                    <div>
                        <span class="text-stone-400 block text-[10px] uppercase tracking-wider font-semibold">Framework</span>
                        <span class="text-teal-800 font-black">Laravel v10+</span>
                    </div>
                    <div class="h-8 w-px bg-stone-200"></div>
                    <div>
                        <span class="text-stone-400 block text-[10px] uppercase tracking-wider font-semibold">Lisensi</span>
                        <span class="text-stone-800 font-black">Private / POS</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection