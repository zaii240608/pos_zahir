<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem POS Zahir - Aplikasi Kasir</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- GSAP Animation CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#0f3832',
                            card: '#164840',
                            accent: '#f59e0b',
                            accentHover: '#d97706',
                            lightBg: '#f8fafc',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-lightBg text-slate-800 font-sans min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Header / Navbar -->
    <header class="gsap-nav w-full bg-brand-dark text-white py-3.5 px-6 md:px-12 flex justify-between items-center shadow-md sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="bg-brand-accent text-brand-dark p-2 rounded-xl flex items-center justify-center font-bold">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg leading-none tracking-wide text-white">SISTEM POS</h1>
                <span class="text-[10px] text-amber-300 font-semibold tracking-widest uppercase">Aplikasi Kasir</span>
            </div>
        </div>
        
        <a href="{{ route('login') }}" class="flex items-center gap-2 bg-brand-accent hover:bg-brand-accentHover text-slate-900 font-bold px-5 py-2 rounded-full transition-all duration-300 shadow-md transform hover:scale-105">
            <span>Login</span>
            <i data-lucide="log-in" class="w-4 h-4"></i>
        </a>
    </header>

    <!-- Hero Section -->
    <main class="max-w-6xl mx-auto px-6 py-12 md:py-16 flex-grow flex flex-col justify-center items-center text-center">
        
        <div class="gsap-badge inline-flex items-center gap-2 bg-emerald-100 border border-emerald-300 text-brand-dark text-xs font-bold px-4 py-1.5 rounded-full mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Siap Digunakan untuk Transaksi Real-Time
        </div>

        <h1 class="gsap-title text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight max-w-3xl">
            Kelola Penjualan, Stok & Transaksi Kasir Dalam Satu Aplikasi
        </h1>

        <p class="gsap-desc text-base md:text-lg text-slate-600 mb-10 max-w-2xl font-medium leading-relaxed">
            Solusi digital cepat dan presisi untuk memantau performa toko, ketersediaan produk, serta laporan riwayat penjualan harian Anda secara akurat.
        </p>

        <!-- Call to Action -->
        <div class="gsap-btn flex flex-col sm:flex-row items-center gap-4 mb-14">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-3 bg-brand-dark hover:bg-brand-card text-white font-bold text-lg px-8 py-4 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <span>Masuk ke Halaman Kasir</span>
                <i data-lucide="arrow-right" class="w-5 h-5 text-brand-accent"></i>
            </a>

            <!-- Badge Akses Terproteksi -->
            <div class="inline-flex items-center gap-2 bg-slate-200/60 border border-slate-300 text-slate-600 text-xs font-semibold px-4 py-3.5 rounded-2xl">
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                <span>Akses Terautentikasi (Multi-Role)</span>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full text-left">
            
            <div class="gsap-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-emerald-50 text-brand-dark rounded-xl flex items-center justify-center mb-4">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Manajemen Stok</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Pantau ketersediaan produk secara real-time lengkap dengan peringatan stok menipis.</p>
            </div>

            <div class="gsap-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-amber-50 text-brand-accentHover rounded-xl flex items-center justify-center mb-4">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Transaksi Cepat</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Proses pemesanan barang dan kasir yang responsif untuk mempercepat layanan pelanggan.</p>
            </div>

            <div class="gsap-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Riwayat & Laporan</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Rekapitulasi total penjualan harian, mingguan, dan metode pembayaran tunai/non-tunai.</p>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-4 text-xs font-semibold text-slate-500 border-t border-slate-200 bg-white">
        &copy; {{ date('Y') }} SISTEM POS. All rights reserved.
    </footer>

    <!-- Script Lucide & GSAP Animations -->
    <script>
        lucide.createIcons();

        document.addEventListener("DOMContentLoaded", () => {
            const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

            tl.from(".gsap-nav", { y: -50, opacity: 0, duration: 0.8 })
              .from(".gsap-badge", { y: 20, opacity: 0, duration: 0.5 }, "-=0.3")
              .from(".gsap-title", { y: 30, opacity: 0, duration: 0.6 }, "-=0.3")
              .from(".gsap-desc", { y: 30, opacity: 0, duration: 0.6 }, "-=0.4")
              .from(".gsap-btn", { scale: 0.8, opacity: 0, duration: 0.5 }, "-=0.3")
              .from(".gsap-card", { y: 40, opacity: 0, duration: 0.6, stagger: 0.15 }, "-=0.3");
        });
    </script>
</body>
</html>