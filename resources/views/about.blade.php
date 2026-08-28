@extends('layouts.app')

@section('title', 'Tentang Aplikasi - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50/50 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- 1. Hero Section (Solid Dark Teal) -->
            <div class="relative overflow-hidden rounded-3xl bg-[#0f4c4a] text-white p-8 md:p-12 shadow-lg border border-teal-900/40">
                <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                    <div class="space-y-4 max-w-2xl">
                        <div class="inline-flex items-center gap-2 bg-amber-400/10 border border-amber-400/20 px-3 py-1 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="text-amber-300 text-xs font-black tracking-wider uppercase">Versi 1.0.0</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight">
                            Solusi Kasir & Manajemen Stok Pintar
                        </h1>
                        <p class="text-teal-100/90 text-sm md:text-base font-normal leading-relaxed">
                            Sistem Point of Sale (POS) modern yang dirancang presisi untuk mempercepat alur transaksi, pemantauan riwayat penjualan mendalam, dan pengelolaan inventaris secara real-time.
                        </p>
                    </div>

                    <!-- Decorative Badge / Icon -->
                    <div class="shrink-0 self-center md:self-auto">
                        <div class="w-24 h-24 bg-amber-400/20 border border-amber-400/30 rounded-3xl flex items-center justify-center text-amber-400 shadow-xl">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Highlight Keunggulan (Metrics Grid) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400 group-hover:text-teal-700 transition-colors">Pembaruan Stok</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <p class="text-2xl font-black text-slate-800">Real-Time</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400 group-hover:text-teal-700 transition-colors">Metode Bayar</span>
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    </div>
                    <p class="text-2xl font-black text-slate-800">Multi-Method</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400 group-hover:text-teal-700 transition-colors">Cetak Struk Nota</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    <p class="text-2xl font-black text-slate-800">Fast Print</p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400 group-hover:text-teal-700 transition-colors">Hold Penjualan</span>
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    </div>
                    <p class="text-2xl font-black text-slate-800">Safe Draft</p>
                </div>
            </div>

            <!-- 3. Fitur Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-3xl p-7 border border-slate-200/80 shadow-sm hover:border-teal-200 transition-all duration-300 space-y-4 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-[#0f4c4a] flex items-center justify-center border border-teal-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-base">Kasir & Multi Pembayaran</h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Dukungan fleksibel untuk berbagai metode transaksi tunai (Cash), QRIS, maupun Transfer Bank dengan kalkulasi otomatis yang presisi.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-3xl p-7 border border-slate-200/80 shadow-sm hover:border-amber-200 transition-all duration-300 space-y-4 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center border border-amber-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-base">Sistem Hold Stock (Draft)</h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Fitur penahanan stok sementara secara akurat saat transaksi berada dalam status OPEN/draft untuk mencegah *overbooking* barang.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-3xl p-7 border border-slate-200/80 shadow-sm hover:border-teal-200 transition-all duration-300 space-y-4 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-[#0f4c4a] flex items-center justify-center border border-teal-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-base">Pantau Riwayat Realtime</h3>
                        <p class="text-slate-500 text-xs leading-relaxed">
                            Rekap laporan transaksi kasir harian, mingguan, hingga bulanan yang tercatat rapi untuk mempermudah pemantauan performa bisnis.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 4. Alur Kerja Singkat -->
            <div class="bg-white rounded-3xl p-7 md:p-9 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-extrabold text-xs uppercase tracking-wider text-slate-400">Alur Kerja Singkat</h3>
                    <span class="text-xs font-semibold text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-100">3 Langkah Mudah</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative bg-slate-50/80 p-5 rounded-2xl border border-slate-100 space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-[#0f4c4a] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm">1</span>
                            <p class="font-extrabold text-sm text-slate-800">Pilih Produk</p>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed pl-11">Cari dan tambahkan barang pesanan ke keranjang transaksi kasir.</p>
                    </div>

                    <div class="relative bg-slate-50/80 p-5 rounded-2xl border border-slate-100 space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-[#0f4c4a] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm">2</span>
                            <p class="font-extrabold text-sm text-slate-800">Pilih Pembayaran</p>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed pl-11">Selesaikan dengan Tunai, QRIS, Transfer, atau simpan sebagai Draft.</p>
                    </div>

                    <div class="relative bg-slate-50/80 p-5 rounded-2xl border border-slate-100 space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-[#0f4c4a] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm">3</span>
                            <p class="font-extrabold text-sm text-slate-800">Selesai & Cetak</p>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed pl-11">Stok terpotong otomatis dan nota transaksi siap untuk dicetak.</p>
                    </div>
                </div>
            </div>

            <!-- 5. Spesifikasi & Info Sistem -->
            <div class="bg-white rounded-3xl p-7 md:p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-1">
                    <h4 class="font-black text-slate-800 text-base">Informasi & Teknologi Sistem</h4>
                    <p class="text-xs text-slate-500 font-medium">Spesifikasi *tech stack* utama yang digunakan dalam membangun aplikasi ini.</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs border border-slate-200">PHP 8.3+</span>
                    <span class="px-3.5 py-1.5 rounded-xl bg-rose-50 text-rose-700 font-extrabold text-xs border border-rose-200/60">Laravel v13</span>
                    <span class="px-3.5 py-1.5 rounded-xl bg-sky-50 text-sky-700 font-extrabold text-xs border border-sky-200/60">Tailwind CSS</span>
                    <span class="px-3.5 py-1.5 rounded-xl bg-amber-50 text-amber-800 font-extrabold text-xs border border-amber-200">MySQL</span>
                </div>
            </div>

            <!-- 6. Profil Pengembang -->
            <div class="bg-white rounded-3xl p-7 md:p-8 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center gap-6">
                <!-- Foto Developer -->
                <div class="relative shrink-0">
                    <img src="{{ asset('assets/images/zai.jpg') }}" alt="Foto Developer" class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover border-2 border-slate-100 shadow-md">
                    <span class="absolute -bottom-2 -right-2 bg-[#0f4c4a] text-amber-400 p-2 rounded-xl shadow-md border border-teal-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </span>
                </div>

                <!-- Info Profil & Kontak -->
                <div class="space-y-3 text-center sm:text-left flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="inline-block px-3 py-0.5 text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-900 rounded-full border border-amber-200/80 mb-1">
                                Pengembang Aplikasi
                            </span>
                            <h3 class="text-xl font-extrabold text-slate-800">Muhammad Zahir Luthfii</h3>
                            <p class="text-xs text-[#0f4c4a] font-bold">Junior Web Developer</p>
                        </div>

                        <!-- Action Link -->
                        <a href="https://github.com/zaii240608" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            <span>GitHub Profile</span>
                        </a>
                    </div>

                    <p class="text-slate-500 text-xs leading-relaxed max-w-2xl">
                        Dirancang dan dikembangkan sebagai solusi Point of Sale (POS) modular yang berfokus pada pengalaman pengguna yang intuitif, kecepatan proses transaksi, dan efisiensi manajemen inventaris toko.
                    </p>
                </div>
            </div>

        </div>
    </div>

@endsection