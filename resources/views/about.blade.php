@extends('layouts.app')

@section('title', 'Tentang Aplikasi - POS')

@section('content')

    <!-- Memanggil Navbar -->
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- 1. Hero Section -->
            <div class="bg-[#0f4c4a] text-white rounded-3xl p-8 md:p-10 shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-3 z-10 max-w-2xl">
                    <span class="bg-amber-400 text-[#0f4c4a] text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full">
                        Versi 1.0.0
                    </span>
                    <h2 class="text-3xl md:text-4xl font-black tracking-tight">Solusi Kasir dan Manajemen Stok</h2>
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

            <!-- 2. Highlight Keunggulan (Metrics Bar) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm text-center">
                    <p class="text-2xl font-black text-[#0f4c4a]">Real-Time</p>
                    <p class="text-[11px] text-stone-500 font-semibold uppercase mt-0.5">Pembaruan Stok</p>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm text-center">
                    <p class="text-2xl font-black text-[#0f4c4a]">Multi-Method</p>
                    <p class="text-[11px] text-stone-500 font-semibold uppercase mt-0.5">Metode Bayar</p>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm text-center">
                    <p class="text-2xl font-black text-[#0f4c4a]">Fast Print</p>
                    <p class="text-[11px] text-stone-500 font-semibold uppercase mt-0.5">Cetak Struk Nota</p>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-stone-200/80 shadow-sm text-center">
                    <p class="text-2xl font-black text-[#0f4c4a]">Safe Draft</p>
                    <p class="text-[11px] text-stone-500 font-semibold uppercase mt-0.5">Hold Penjualan</p>
                </div>
            </div>

            <!-- 3. Fitur Utama -->
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

            <!-- 4. Alur Kerja Singkat -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-stone-200/80 shadow-sm space-y-4">
                <h3 class="font-extrabold text-xs uppercase tracking-wider text-stone-400">Cara Kerja Singkat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-start gap-3 bg-stone-50 p-4 rounded-2xl border border-stone-100">
                        <span class="w-7 h-7 rounded-xl bg-[#0f4c4a] text-white flex items-center justify-center font-black text-xs shrink-0">1</span>
                        <div>
                            <p class="font-extrabold text-xs text-stone-800">Pilih Produk</p>
                            <p class="text-[11px] text-stone-500 mt-0.5">Cari dan tambahkan barang ke keranjang transaksi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-stone-50 p-4 rounded-2xl border border-stone-100">
                        <span class="w-7 h-7 rounded-xl bg-[#0f4c4a] text-white flex items-center justify-center font-black text-xs shrink-0">2</span>
                        <div>
                            <p class="font-extrabold text-xs text-stone-800">Pilih Pembayaran</p>
                            <p class="text-[11px] text-stone-500 mt-0.5">Pilih pembayaran Tunai, QRIS, atau simpan sebagai Draft.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-stone-50 p-4 rounded-2xl border border-stone-100">
                        <span class="w-7 h-7 rounded-xl bg-[#0f4c4a] text-white flex items-center justify-center font-black text-xs shrink-0">3</span>
                        <div>
                            <p class="font-extrabold text-xs text-stone-800">Selesai & Cetak</p>
                            <p class="text-[11px] text-stone-500 mt-0.5">Stok terpotong otomatis dan struk siap dicetak.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Spesifikasi & Info Sistem -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-stone-200/80 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-1">
                    <h4 class="font-black text-stone-800 text-base">Informasi Sistem</h4>
                    <p class="text-xs text-stone-500 font-medium">Spesifikasi teknologi yang digunakan pada aplikasi ini.</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1.5 rounded-xl bg-stone-100 text-stone-700 font-extrabold text-xs border border-stone-200">PHP 8.2+</span>
                    <span class="px-3 py-1.5 rounded-xl bg-red-50 text-red-700 font-extrabold text-xs border border-red-100">Laravel v10</span>
                    <span class="px-3 py-1.5 rounded-xl bg-sky-50 text-sky-700 font-extrabold text-xs border border-sky-100">Tailwind CSS</span>
                    <span class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 font-extrabold text-xs border border-amber-200">MySQL</span>
                </div>
            </div>

            <!-- 6. Card Profil Pengembang (Di Bagian Paling Bawah) -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-stone-200/80 shadow-sm flex flex-col sm:flex-row items-center gap-6">
                <!-- Foto Developer -->
                <div class="relative shrink-0">
                    <img src="{{ asset('assets/images/pfp.jpg') }}" alt="Foto Developer" class="w-24 h-24 md:w-28 md:h-28 rounded-2xl object-cover border-2 border-stone-200 shadow-sm">
                    <span class="absolute -bottom-2 -right-2 bg-[#0f4c4a] text-white p-1.5 rounded-xl shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </span>
                </div>

                <!-- Info Profil & Kontak -->
                <div class="space-y-2 text-center sm:text-left flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black uppercase bg-amber-100 text-amber-900 rounded-full border border-amber-200 mb-1">
                                Pengembang Aplikasi
                            </span>
                            <h3 class="text-lg font-extrabold text-stone-800">Muhammad Zahir Luthfii</h3>
                            <p class="text-xs text-[#0f4c4a] font-bold">Junior Web Developer</p>
                        </div>

                        <!-- Social Link / Action Button -->
                        <div class="flex items-center justify-center sm:justify-start gap-2 pt-2 sm:pt-0">
                            <a href="https://github.com/zaii240608" target="_blank" class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-[11px] font-bold rounded-xl border border-stone-200 transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                GitHub
                            </a>
                        </div>
                    </div>

                    <p class="text-stone-500 text-xs leading-relaxed">
                        Dirancang dan dikembangkan sebagai solusi Point of Sale (POS) yang mengedepankan kemudahan penggunaan, efisiensi, dan performa tinggi.
                    </p>
                </div>
            </div>

        </div>
    </div>

@endsection