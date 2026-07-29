@extends('layouts.app')

@section('title', 'Riwayat Penjualan Mingguan - POS')

@section('content')

    <!-- Memanggil Navbar -->
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Header Halaman & Tombol Navigasi -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Riwayat Penjualan Mingguan</h1>
                    <p class="text-xs text-stone-500 mt-1">Rekap omzet dan transaksi penjualan berdasarkan periode mingguan.</p>
                </div>

                <!-- Tombol Switcher Bulanan / Mingguan -->
                <div class="flex items-center gap-2 bg-stone-100 p-1.5 rounded-2xl border border-stone-200/60">
                    <a href="{{ route('admin.history.index') }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold text-stone-500 hover:text-stone-900 transition-all">
                        Bulanan
                    </a>
                    <a href="{{ route('admin.history.week') }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white text-stone-900 shadow-sm">
                        Mingguan
                    </a>
                </div>
            </div>

            @if(!empty($historyMingguan) && count($historyMingguan) > 0)
                @php
                    // Helper format rupiah singkat
                    $formatRingkas = function($nominal) {
                        if ($nominal >= 1000000000) {
                            return number_format($nominal / 1000000000, 1, ',', '.') . 'M';
                        } elseif ($nominal >= 1000000) {
                            return number_format($nominal / 1000000, 1, ',', '.') . 'Jt';
                        }
                        return number_format($nominal, 0, ',', '.');
                    };

                    // Hitung Grand Total
                    $grandTotalOmzet = 0;
                    $grandTotalTransaksi = 0;

                    foreach($historyMingguan as $item) {
                        $grandTotalOmzet += (float) ($item->total_omzet ?? 0);
                        $grandTotalTransaksi += (int) ($item->total_transaksi ?? 0);
                    }

                    $totalData = count($historyMingguan);
                    $minWidthPx = max(100, $totalData * 110); 
                    $rataRataMingguan = $totalData > 0 ? $grandTotalOmzet / $totalData : 0;

                    // Dibalik khusus grafik agar kronologis dari kiri (lama) ke kanan (terbaru)
                    $historyForChart = is_array($historyMingguan) 
                        ? array_reverse($historyMingguan) 
                        : $historyMingguan->reverse();

                    $chartLabels = [];
                    $chartData = [];

                    foreach($historyForChart as $item) {
                        $label = $item->label_minggu ?? (isset($item->minggu_ke) ? 'Minggu ' . $item->minggu_ke : 'Minggu');
                        $chartLabels[] = $label;
                        $chartData[] = (float) ($item->total_omzet ?? 0);
                    }
                @endphp

                <!-- Summary Cards Section (Disamakan dengan layout Bulanan) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Card 1: Total Omzet -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Total Omzet Periode Ini</p>
                            <h3 class="text-2xl font-black text-stone-900 mt-1">Rp {{ number_format($grandTotalOmzet, 0, ',', '.') }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>

                    <!-- Card 2: Total Transaksi -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Total Transaksi</p>
                            <h3 class="text-2xl font-black text-stone-900 mt-1">{{ number_format($grandTotalTransaksi, 0, ',', '.') }} <span class="text-sm font-normal text-stone-500">Transaksi</span></h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>

                    <!-- Card 3: Rata-rata per Minggu -->
                    <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Rata-rata / Minggu</p>
                            <h3 class="text-2xl font-black text-stone-900 mt-1">Rp {{ $formatRingkas($rataRataMingguan) }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Section Grafik Tren Mingguan (Scrollable Container) -->
                <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-stone-900 tracking-tight">Grafik Penjualan Mingguan</h2>
                            <p class="text-xs text-stone-500">Perbandingan perolehan omzet dari minggu ke minggu.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-semibold text-stone-400 sm:hidden">Geser grafik &rarr;</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span> Mode Mingguan
                            </span>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div id="chartScrollContainer" class="w-full overflow-x-auto pb-4 custom-scrollbar">
                        <div class="relative h-72 sm:h-80" style="min-width: max(100%, {{ $minWidthPx }}px);">
                            <canvas id="weekChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grid List Detail Per Minggu -->
                <div>
                    <h2 class="text-lg font-bold text-stone-900 mb-4 tracking-tight">Rincian Per Minggu</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($historyMingguan as $item)
                            <div class="bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="text-[11px] font-extrabold text-indigo-600 uppercase tracking-wider">Periode</span>
                                        <h3 class="text-xl font-black text-stone-900 mt-0.5">
                                            {{ $item->label_minggu ?? ('Minggu ke-' . ($item->minggu_ke ?? '-')) }}
                                        </h3>
                                        @if(!empty($item->rentang_tanggal))
                                            <p class="text-[11px] text-stone-400 font-medium mt-0.5">{{ $item->rentang_tanggal }}</p>
                                        @endif
                                    </div>
                                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>
                                <div class="space-y-2 text-xs font-medium text-stone-500 border-t border-stone-100 pt-4">
                                    <p class="flex justify-between items-center">
                                        <span>Total Omzet:</span> 
                                        <span class="text-indigo-600 font-black text-sm">Rp {{ number_format($item->total_omzet ?? 0, 0, ',', '.') }}</span>
                                    </p>
                                    <p class="flex justify-between items-center">
                                        <span>Total Transaksi:</span> 
                                        <span class="text-stone-900 font-bold">{{ number_format($item->total_transaksi ?? 0, 0, ',', '.') }} Transaksi</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @else
                <!-- Tampilan Kosong -->
                <div class="py-16 text-center bg-white rounded-3xl border border-stone-200/80 shadow-sm">
                    <svg class="w-12 h-12 mx-auto mb-3 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-base font-bold text-stone-800">Belum ada data mingguan</h3>
                    <p class="text-stone-500 text-xs font-medium mt-1">Data penjualan mingguan akan muncul setelah transaksi tercatat.</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Custom Scrollbar Style (Sama dengan Bulanan) -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f5f5f4;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
    </style>

    <!-- Script Chart.js Mingguan -->
    @if(!empty($historyMingguan) && count($historyMingguan) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const weekCanvas = document.getElementById('weekChart');
                if (!weekCanvas) return;

                const ctx = weekCanvas.getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(99, 102, 241, 0.25)'); // Indigo accent
                gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Omzet Mingguan (Rp)',
                            data: @json($chartData),
                            borderColor: '#6366f1',
                            borderWidth: 3,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#6366f1',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#4f46e5',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1c1917',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 13 },
                                padding: 12,
                                cornerRadius: 12,
                                callbacks: {
                                    label: function(context) {
                                        let value = context.raw || 0;
                                        return ' Omzet: Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11 }, color: '#78716c' }
                            },
                            y: {
                                border: { dash: [4, 4] },
                                grid: { color: '#e7e5e4' },
                                ticks: {
                                    font: { size: 11 },
                                    color: '#78716c',
                                    callback: function(value) {
                                        if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                                        if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                        if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                        return 'Rp ' + value;
                                    }
                                }
                            }
                        }
                    }
                });

                // Scroll otomatis slider ke data paling kanan (minggu terbaru)
                setTimeout(() => {
                    const scrollContainer = document.getElementById('chartScrollContainer');
                    if (scrollContainer) {
                        scrollContainer.scrollLeft = scrollContainer.scrollWidth;
                    }
                }, 100);
            });
        </script>
    @endif

@endsection