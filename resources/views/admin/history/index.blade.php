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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Mingguan</span>
                        </a>
                    </div>

                    <!-- Date Selector Right Side -->
                    <div class="flex items-center justify-end space-x-3 text-xs text-slate-500 font-medium">
                        <span>Rekapitulasi Total</span>
                        <div class="flex items-center space-x-1 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-800 font-bold">
                            <span>Semua Bulan</span>
                        </div>
                    </div>
                </div>

                @if($historyBulanan->isNotEmpty())
                    @php
                        // Helper format rupiah singkat (Jt / M)
                        $formatRingkas = function($nominal) {
                            if ($nominal >= 1000000000) {
                                return number_format($nominal / 1000000000, 1, ',', '.') . 'M';
                            } elseif ($nominal >= 1000000) {
                                return number_format($nominal / 1000000, 1, ',', '.') . 'Jt';
                            }
                            return number_format($nominal, 0, ',', '.');
                        };

                        // Menyiapkan data kronologis untuk Chart
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
                        $jumlahBulan = $historyBulanan->count() > 0 ? $historyBulanan->count() : 1;
                        
                        $rataRataOmzet = $grandTotalOmzet / $jumlahBulan;
                        $rataRataTransaksi = round($grandTotalTransaksi / $jumlahBulan);
                        $maxOmzet = $historyBulanan->max('total_omzet');
                    @endphp

                    <!-- 2. Main KPI Metrics Row (Header Ringkasan) -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-2">
                        <!-- Metric 1: Total Omzet -->
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center space-x-1">
                                <span>Total Omzet</span>
                            </div>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    Rp {{ $formatRingkas($grandTotalOmzet) }}
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
                            </div>
                        </div>

                        <!-- Metric 3: Rata-rata Omzet -->
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center space-x-1">
                                <span>Rata-rata / Bulan</span>
                            </div>
                            <div class="flex items-baseline space-x-2 mt-1">
                                <span class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                    Rp {{ $formatRingkas($rataRataOmzet) }}
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

                    <!-- 3. Sparkline Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                        <!-- Mini Card 1 -->
                        <div class="bg-cyan-50/40 border border-cyan-100 rounded-xl p-4 flex flex-col justify-between hover:border-cyan-300 transition">
                            <span class="text-xs font-semibold text-slate-600">Penjualan Tertinggi</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline1"></canvas>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                Rp {{ $formatRingkas($maxOmzet) }}
                            </div>
                        </div>

                        <!-- Mini Card 2 -->
                        <div class="bg-cyan-50/40 border border-cyan-100 rounded-xl p-4 flex flex-col justify-between hover:border-cyan-300 transition">
                            <span class="text-xs font-semibold text-slate-600">Rata-rata Transaksi</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline2"></canvas>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                {{ number_format($rataRataTransaksi, 0, ',', '.') }} <span class="text-xs font-normal text-slate-500">trx/bln</span>
                            </div>
                        </div>

                        <!-- Mini Card 3 -->
                        <div class="bg-cyan-50/40 border border-cyan-100 rounded-xl p-4 flex flex-col justify-between hover:border-cyan-300 transition">
                            <span class="text-xs font-semibold text-slate-600">Rata-rata / Transaksi</span>
                            <div class="h-10 my-2">
                                <canvas id="sparkline3"></canvas>
                            </div>
                            <div class="text-xl font-bold text-slate-800">
                                Rp {{ $grandTotalTransaksi > 0 ? number_format($grandTotalOmzet / $grandTotalTransaksi, 0, ',', '.') : 0 }}
                            </div>
                        </div>

                        <!-- Mini Card 4 -->
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

                    <!-- 4. Main Chart Section -->
                    <div class="pt-4 relative">
                        <div class="h-80 sm:h-96 w-full">
                            <canvas id="mainAnalyticsChart"></canvas>
                        </div>

                        <!-- Chart Controls -->
                        <div class="flex flex-wrap items-center justify-end gap-4 text-xs font-medium text-slate-600 mt-4 border-t border-slate-100 pt-3">
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer">
                                <input type="checkbox" checked id="toggleOmzet" class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-sky-600 mr-1.5"></span> Total Omzet</span>
                            </label>
                            <label class="inline-flex items-center space-x-1.5 cursor-pointer">
                                <input type="checkbox" checked id="toggleTransaksi" class="rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-sm bg-cyan-400 mr-1.5"></span> Transaksi</span>
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 5. Grid List Data Bulan -->
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

                    const gradOmzet = ctx.createLinearGradient(0, 0, 0, 300);
                    gradOmzet.addColorStop(0, 'rgba(2, 132, 199, 0.35)');
                    gradOmzet.addColorStop(1, 'rgba(2, 132, 199, 0.01)');

                    const gradTrx = ctx.createLinearGradient(0, 0, 0, 300);
                    gradTrx.addColorStop(0, 'rgba(56, 189, 248, 0.3)');
                    gradTrx.addColorStop(1, 'rgba(56, 189, 248, 0.01)');

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
                                            if (v >= 1000000000) return (v/1000000000) + 'M';
                                            if (v >= 1000000) return (v/1000000) + 'Jt';
                                            return v;
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

                    document.getElementById('toggleOmzet').addEventListener('change', function(e) {
                        mainChart.setDatasetVisibility(0, e.target.checked);
                        mainChart.update();
                    });
                    document.getElementById('toggleTransaksi').addEventListener('change', function(e) {
                        mainChart.setDatasetVisibility(1, e.target.checked);
                        mainChart.update();
                    });
                }

                // Helper Sparkline Charts
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

                createSparkline('sparkline1', dataOmzet, '#0284c7');
                createSparkline('sparkline2', dataTransaksi, '#38bdf8');
                createSparkline('sparkline3', dataOmzet, '#0284c7');
                createSparkline('sparkline4', dataOmzet, '#0369a1');
            });
        </script>
    @endif

@endsection