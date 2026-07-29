@extends('layouts.app')

@section('title', 'Riwayat Penjualan Bulanan - POS Analytics')

@section('content')

    <!-- Memanggil Navbar -->
    @include('layouts.navbar')

    <div class="min-h-screen bg-[#f4f7f9] text-slate-700 py-6 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Card Utama Dashboard Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 space-y-6">

                <!-- 1. Top Navigation Bar (Tabs) & Date Picker -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 gap-4">
                    <!-- Tabs Navigasi -->
                    <div class="flex items-center space-x-6 text-sm font-semibold text-slate-500">
                        <a href="{{ route('admin.history.index') }}" class="flex items-center space-x-1.5 text-rose-500 border-b-2 border-rose-500 pb-2 -mb-4 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Bulanan</span>
                        </a>
                        <a href="{{ route('admin.history.week') }}" class="flex items-center space-x-1.5 hover:text-slate-800 transition pb-2 -mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v25a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path></svg>
                            <span>Mingguan</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1.5 hover:text-slate-800 transition pb-2 -mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span>Performa</span>
                        </a>
                        <a href="#" class="flex items-center space-x-1.5 hover:text-slate-800 transition pb-2 -mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            <span>Pengaturan</span>
                        </a>
                    </div>

                    <!-- Date Selector Right Side -->
                    <div class="flex items-center justify-end space-x-3 text-xs text-slate-500 font-medium">
                        <span>Rekapitulasi Tahun {{ date('Y') }}</span>
                        <div class="flex items-center space-x-1 bg-slate-100 hover:bg-slate-200/80 px-3 py-1.5 rounded-lg border border-slate-200 cursor-pointer transition text-slate-800 font-bold">
                            <button>&lt;</button>
                            <span>Semua Bulan</span>
                            <button>&gt;</button>
                        </div>
                    </div>
                </div>

                @if($historyBulanan->isNotEmpty())
                    @php
                        // Menyiapkan data kronologis
                        $sortedHistory = $historyBulanan->sortBy(function($item) {
                            return sprintf('%04d%02d', $item->tahun, $item->bulan);
                        });

                        $chartLabels = [];
                        $chartOmzet = [];
                        $chartTransaksi = [];

                        foreach($sortedHistory as $item) {
                            $chartLabels[] = \Carbon\Carbon::createFromDate($item->tahun, $item->bulan, 1)->translatedFormat('M Y');
                            $chartOmzet[] = (float) $item->total_omzet;
                            $chartTransaksi[] = (int) $item->total_transaksi;
                        }

                        $grandTotalOmzet = $historyBulanan->sum('total_omzet');
                        $grandTotalTransaksi = $historyBulanan->sum('total_transaksi');
                        $rataRataOmzet = $historyBulanan->count() > 0 ? $grandTotalOmzet / $historyBulanan->count() : 0;
                        $rataRataTransaksi = $historyBulanan->count() > 0 ? round($grandTotalTransaksi / $historyBulanan->count()) : 0;
                    @endphp

                    <!-- 2. Main KPI Metrics Row (Header Ringkasan) -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-2">
                        <!-- Metric 1: Total Omzet -->
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center space-x-1">
                                <span>Total Omzet</span>
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    Rp {{ $grandTotalOmzet >= 1000000 ? number_format($grandTotalOmzet / 1000000, 1, ',', '.') . 'M' : number_format($grandTotalOmzet, 0, ',', '.') }}
                                </span>
                                <span class="inline-flex items-center text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-rose-100 text-rose-600">
                                    +14%
                                </span>
                            </div>
                        </div>

                        <!-- Metric 2: Total Transaksi -->
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center space-x-1">
                                <span>Total Transaksi</span>
                            </div>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    {{ number_format($grandTotalTransaksi, 0, ',', '.') }}
                                </span>
                                <span class="inline-flex items-center text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-emerald-100 text-emerald-600">
                                    +8%
                                </span>
                            </div>
                        </div>

                        <!-- Metric 3: Rata-rata Omzet -->
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center space-x-1">
                                <span>Rata-rata / Bulan</span>
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($rataRataOmzet / 1000000, 1, ',', '.') }}M
                                </span>
                                <span class="inline-flex items-center text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-rose-100 text-rose-600">
                                    -2%
                                </span>
                            </div>
                        </div>

                        <!-- Metric 4: Live Indicator -->
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                <span class="text-rose-500 font-bold">Bulan Aktif</span>
                            </div>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    {{ date('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Sparkline Cards Grid (Kartu Kecil dengan Mini Chart) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                        <!-- Mini Card 1 -->
                        <div class="bg-cyan-50/40 border border-cyan-100 rounded-xl p-4 flex flex-col justify-between hover:border-cyan-300 transition">
                            <span class="text-xs font-semibold text-slate-600">Penjualan Tertinggi</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline1"></canvas>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                Rp {{ number_format($historyBulanan->max('total_omzet') / 1000000, 1, ',', '.') }}M
                            </div>
                        </div>

                        <!-- Mini Card 2 -->
                        <div class="bg-cyan-50/40 border border-cyan-100 rounded-xl p-4 flex flex-col justify-between hover:border-cyan-300 transition">
                            <span class="text-xs font-semibold text-slate-600">Rata-rata Transaksi</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline2"></canvas>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                {{ $rataRataTransaksi }} <span class="text-xs font-normal text-slate-500">trx/bln</span>
                            </div>
                        </div>

                        <!-- Mini Card 3 -->
                        <div class="bg-cyan-50/40 border border-cyan-100 rounded-xl p-4 flex flex-col justify-between hover:border-cyan-300 transition">
                            <span class="text-xs font-semibold text-slate-600">Performa Omzet</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline3"></canvas>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                98.4<span class="text-xs font-normal text-slate-500">% Target</span>
                            </div>
                        </div>

                        <!-- Mini Card 4 (Active/Selected Card) -->
                        <div class="bg-cyan-50 border-2 border-cyan-400 rounded-xl p-4 flex flex-col justify-between shadow-sm relative">
                            <span class="text-xs font-semibold text-cyan-900">Total Bulan Tercatat</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline4"></canvas>
                            </div>
                            <div class="text-xl font-bold text-cyan-950">
                                {{ $historyBulanan->count() }} <span class="text-xs font-normal text-cyan-700">Bulan</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Main Chart Section (Grafik Area Besar) -->
                    <div class="pt-4 relative">
                        <div class="h-80 sm:h-96 w-full">
                            <canvas id="mainAnalyticsChart"></canvas>
                        </div>

                        <!-- Chart Legends / Filters di Pojok Kanan Bawah -->
                        <div class="flex flex-wrap items-center justify-end gap-4 text-xs font-medium text-slate-600 mt-4 border-t border-slate-100 pt-3">
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer">
                                <input type="checkbox" checked class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <span>Garis Tren</span>
                            </label>
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer">
                                <input type="checkbox" class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <span>Bandingkan Filter</span>
                            </label>
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer">
                                <input type="checkbox" checked id="toggleOmzet" class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-sky-400 mr-1.5"></span> Total Omzet</span>
                            </label>
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer">
                                <input type="checkbox" checked id="toggleTransaksi" class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-cyan-200 border border-cyan-400 mr-1.5"></span> Transaksi</span>
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 5. Grid List Data Bulan (Atas Nama Rincian) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-800 tracking-tight">Rincian Data Per Bulan</h2>
                    <span class="text-xs text-slate-500">Klik bulan untuk detail transaksi</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($historyBulanan as $item)
                        @php
                            $namaBulan = \Carbon\Carbon::createFromDate($item->tahun, $item->bulan, 1)->translatedFormat('F Y');
                        @endphp
                        <a href="{{ route('admin.history.month', [$item->tahun, $item->bulan]) }}" 
                           class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-cyan-400 hover:shadow-md transition group flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="text-[10px] font-bold text-cyan-600 uppercase tracking-wider">{{ $item->tahun }}</span>
                                    <h3 class="text-lg font-extrabold text-slate-800 group-hover:text-cyan-600 transition">{{ $namaBulan }}</h3>
                                </div>
                                <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-cyan-50 group-hover:text-cyan-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                            <div class="space-y-1.5 text-xs border-t border-slate-100 pt-3">
                                <div class="flex justify-between items-center text-slate-500">
                                    <span>Omzet Penjualan:</span>
                                    <span class="text-slate-900 font-extrabold text-sm">Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-500">
                                    <span>Total Transaksi:</span>
                                    <span class="text-slate-700 font-bold">{{ number_format($item->total_transaksi, 0, ',', '.') }} Transaksi</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                            <p class="text-slate-400 text-xs">Belum ada riwayat penjualan bulanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Script Integration -->
    @if($historyBulanan->isNotEmpty())
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const labels = @json($chartLabels);
                const dataOmzet = @json($chartOmzet);
                const dataTransaksi = @json($chartTransaksi);

                // --- 1. Main Analytics Area Chart ---
                const mainCanvas = document.getElementById('mainAnalyticsChart');
                if (mainCanvas) {
                    const ctx = mainCanvas.getContext('2d');

                    // Gradient Omzet (Top Area)
                    const gradOmzet = ctx.createLinearGradient(0, 0, 0, 300);
                    gradOmzet.addColorStop(0, 'rgba(56, 189, 248, 0.45)');
                    gradOmzet.addColorStop(1, 'rgba(56, 189, 248, 0.02)');

                    // Gradient Transaksi (Bottom Area)
                    const gradTrx = ctx.createLinearGradient(0, 0, 0, 300);
                    gradTrx.addColorStop(0, 'rgba(186, 230, 253, 0.6)');
                    gradTrx.addColorStop(1, 'rgba(186, 230, 253, 0.05)');

                    const mainChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Total Omzet (Rp)',
                                    data: dataOmzet,
                                    borderColor: '#0284c7',
                                    borderWidth: 2.5,
                                    backgroundColor: gradOmzet,
                                    fill: true,
                                    tension: 0.2,
                                    pointBackgroundColor: '#0284c7',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Total Transaksi',
                                    data: dataTransaksi,
                                    borderColor: '#38bdf8',
                                    borderWidth: 2,
                                    backgroundColor: gradTrx,
                                    fill: true,
                                    tension: 0.2,
                                    pointBackgroundColor: '#38bdf8',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 3,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#0f172a',
                                    titleFont: { size: 12, weight: 'bold' },
                                    bodyFont: { size: 12 },
                                    padding: 10,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function(context) {
                                            if (context.dataset.yAxisID === 'y') {
                                                return ' Omzet: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                            }
                                            return ' Transaksi: ' + context.raw + ' trx';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: '#f1f5f9' },
                                    ticks: { font: { size: 11 }, color: '#64748b' }
                                },
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    grid: { color: '#f1f5f9' },
                                    ticks: {
                                        font: { size: 11 },
                                        color: '#64748b',
                                        callback: function(v) {
                                            return v >= 1000000 ? (v/1000000) + 'M' : v;
                                        }
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: false,
                                    position: 'right',
                                    grid: { drawOnChartArea: false }
                                }
                            }
                        }
                    });

                    // Toggle dataset via checkbox
                    document.getElementById('toggleOmzet').addEventListener('change', function(e) {
                        mainChart.setDatasetVisibility(0, e.target.checked);
                        mainChart.update();
                    });
                    document.getElementById('toggleTransaksi').addEventListener('change', function(e) {
                        mainChart.setDatasetVisibility(1, e.target.checked);
                        mainChart.update();
                    });
                }

                // --- 2. Helper Sparkline Charts (Mini Cards) ---
                const sparklineOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    scales: { x: { display: false }, y: { display: false } },
                    elements: { point: { radius: 0 } }
                };

                const createSparkline = (id, data, color) => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    new Chart(el.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                borderColor: color,
                                borderWidth: 2,
                                tension: 0.3,
                                fill: false
                            }]
                        },
                        options: sparklineOptions
                    });
                };

                createSparkline('sparkline1', dataOmzet, '#38bdf8');
                createSparkline('sparkline2', dataTransaksi, '#0284c7');
                createSparkline('sparkline3', dataOmzet.map(v => v * 0.9), '#0284c7');
                createSparkline('sparkline4', dataOmzet, '#0369a1');
            });
        </script>
    @endif

@endsection