@extends('layouts.app')

@section('title', 'Riwayat Penjualan Bulanan - POS')

@section('content')

    <!-- Memanggil Navbar -->
    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Wrapper Card -->
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm p-6 space-y-6">
                
                <!-- Header Tab Navigasi & Filter Right -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-3">
                    <!-- Tab Navigation -->
                    <div class="flex items-center gap-6">
                        <a href="{{ route('admin.history.index') }}" 
                           class="flex items-center gap-2 pb-2 text-xs font-bold text-teal-700 border-b-2 border-teal-600 transition-all">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Bulanan
                        </a>
                        <a href="{{ route('admin.history.week') }}" 
                           class="flex items-center gap-2 pb-2 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Mingguan
                        </a>
                    </div>

                    <!-- Filter / Status Kanan -->
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span>Rekapitulasi Total</span>
                        <span class="px-2.5 py-1 rounded-md bg-teal-50 text-teal-800 font-bold border border-teal-100">Semua Bulan</span>
                    </div>
                </div>

                @if(!empty($historyBulanan) && count($historyBulanan) > 0)
                    @php
                        // Helper format ringkas
                        $formatRingkas = function($nominal) {
                            if ($nominal >= 1000000000) {
                                return number_format($nominal / 1000000000, 1, ',', '.') . 'M';
                            } elseif ($nominal >= 1000000) {
                                return number_format($nominal / 1000000, 1, ',', '.') . 'Jt';
                            }
                            return number_format($nominal, 0, ',', '.');
                        };

                        // Kalkulasi statistik
                        $grandTotalOmzet = 0;
                        $grandTotalTransaksi = 0;
                        $penjualanTertinggi = 0;

                        foreach($historyBulanan as $item) {
                            $omzet = (float) ($item->total_omzet ?? 0);
                            $trx = (int) ($item->total_transaksi ?? 0);
                            
                            $grandTotalOmzet += $omzet;
                            $grandTotalTransaksi += $trx;
                            if ($omzet > $penjualanTertinggi) {
                                $penjualanTertinggi = $omzet;
                            }
                        }

                        $totalBulanTercatat = count($historyBulanan);
                        $rataRataBulanan = $totalBulanTercatat > 0 ? $grandTotalOmzet / $totalBulanTercatat : 0;
                        $rataRataTrxBulan = $totalBulanTercatat > 0 ? round($grandTotalTransaksi / $totalBulanTercatat) : 0;
                        $rataRataPerTrx = $grandTotalTransaksi > 0 ? $grandTotalOmzet / $grandTotalTransaksi : 0;

                        // Data untuk Grafik (Kronologis)
                        $historyForChart = is_array($historyBulanan) ? array_reverse($historyBulanan) : $historyBulanan->reverse();
                        $chartLabels = [];
                        $chartOmzet = [];
                        $chartTrx = [];

                        foreach($historyForChart as $item) {
                            $chartLabels[] = $item->label_bulan ?? ($item->nama_bulan ?? 'Bulan ' . ($item->bulan_ke ?? ''));
                            $chartOmzet[] = (float) ($item->total_omzet ?? 0);
                            $chartTrx[] = (int) ($item->total_transaksi ?? 0);
                        }

                        $minWidthPx = max(100, $totalBulanTercatat * 80);
                    @endphp

                    <!-- Row 1: Header KPI Stats -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-teal-50/50 border border-teal-100 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-teal-800 uppercase tracking-wider">TOTAL OMZET</p>
                            <h2 class="text-xl font-black text-teal-900 mt-0.5">Rp {{ $formatRingkas($grandTotalOmzet) }}</h2>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">TOTAL TRANSAKSI</p>
                            <h2 class="text-xl font-black text-slate-800 mt-0.5">{{ number_format($grandTotalTransaksi, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">RATA-RATA / BULAN</p>
                            <h2 class="text-xl font-black text-slate-800 mt-0.5">Rp {{ $formatRingkas($rataRataBulanan) }}</h2>
                        </div>
                        <div class="bg-amber-50/70 border border-amber-200/60 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-amber-700 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> BULAN AKTIF
                            </p>
                            <h2 class="text-xl font-black text-amber-900 mt-0.5 truncate">
                                {{ $historyBulanan[0]->label_bulan ?? 'Bulan Ini' }}
                            </h2>
                        </div>
                    </div>

                    <!-- Row 2: Secondary Cards Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 pt-2">
                        <div class="bg-slate-50/80 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-slate-500">Penjualan Tertinggi</p>
                            <h3 class="text-base font-bold text-teal-700 mt-1">Rp {{ $formatRingkas($penjualanTertinggi) }}</h3>
                        </div>

                        <div class="bg-slate-50/80 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-slate-500">Rata-rata Transaksi</p>
                            <h3 class="text-base font-bold text-slate-800 mt-1">
                                {{ $rataRataTrxBulan }} <span class="text-[11px] font-normal text-slate-400">trx/bln</span>
                            </h3>
                        </div>

                        <div class="bg-slate-50/80 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-slate-500">Rata-rata / Transaksi</p>
                            <h3 class="text-base font-bold text-slate-800 mt-1">Rp {{ number_format($rataRataPerTrx, 0, ',', '.') }}</h3>
                        </div>

                        <div class="bg-amber-50/50 border border-amber-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-amber-800">Total Bulan Tercatat</p>
                            <h3 class="text-base font-bold text-amber-900 mt-1">
                                {{ $totalBulanTercatat }} <span class="text-[11px] font-medium text-amber-600">Bulan</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Row 3: Chart Container -->
                    <div class="pt-2">
                        <div id="chartScrollContainer" class="w-full overflow-x-auto pb-2 custom-scrollbar">
                            <div class="relative h-64" style="min-width: max(100%, {{ $minWidthPx }}px);">
                                <canvas id="historyChart"></canvas>
                            </div>
                        </div>

                        <!-- Custom Legend Checkboxes -->
                        <div class="flex items-center justify-end gap-5 text-xs font-semibold text-slate-600 mt-2">
                            <label class="flex items-center gap-1.5 cursor-pointer select-none">
                                <input type="checkbox" id="toggleOmzet" checked class="rounded text-teal-600 focus:ring-teal-500 w-3.5 h-3.5">
                                <span class="w-2.5 h-2.5 rounded-sm bg-teal-600 inline-block"></span> Total Omzet
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer select-none">
                                <input type="checkbox" id="toggleTrx" checked class="rounded text-amber-500 focus:ring-amber-400 w-3.5 h-3.5">
                                <span class="w-2.5 h-2.5 rounded-sm bg-amber-500 inline-block"></span> Transaksi
                            </label>
                        </div>
                    </div>

                    <!-- Row 4: Tabel Rincian Bulanan -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-slate-800">Rincian Per Bulan</h3>
                            <span class="text-xs text-slate-400">Diurutkan dari bulan terbaru</span>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-200/80">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-teal-50/60 border-b border-teal-100 text-teal-900 font-bold uppercase tracking-wider">
                                        <th class="py-3 px-4">Periode Bulan</th>
                                        <th class="py-3 px-4 text-center">Transaksi</th>
                                        <th class="py-3 px-4 text-right">Total Omzet</th>
                                        <th class="py-3 px-4 text-right">Rata-rata / Trx</th>
                                        <th class="py-3 px-4 text-center">Trend Bulanan</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @foreach($historyBulanan as $index => $row)
                                        @php
                                            $omzetBulan = (float) ($row->total_omzet ?? 0);
                                            $trxBulan = (int) ($row->total_transaksi ?? 0);
                                            $avgPerTrx = $trxBulan > 0 ? $omzetBulan / $trxBulan : 0;
                                            
                                            // Kalkulasi trend dibanding bulan sebelumnya
                                            $bulanLalu = $historyBulanan[$index + 1] ?? null;
                                            $omzetLalu = $bulanLalu ? (float) ($bulanLalu->total_omzet ?? 0) : 0;
                                            
                                            $diffPercent = 0;
                                            if ($omzetLalu > 0) {
                                                $diffPercent = (($omzetBulan - $omzetLalu) / $omzetLalu) * 100;
                                            }

                                            // Menentukan parameter bulan & tahun untuk filter
                                            $monthVal = $row->bulan_ke ?? ($row->bulan ?? null);
                                            $yearVal = $row->tahun_ke ?? ($row->tahun ?? date('Y'));
                                        @endphp
                                        <tr class="hover:bg-teal-50/30 transition-colors">
                                            <td class="py-3 px-4 font-bold text-slate-800">
                                                {{ $row->label_bulan ?? ($row->nama_bulan ?? 'Bulan ' . ($row->bulan_ke ?? '-')) }}
                                                @if($index === 0)
                                                    <span class="ml-2 px-2 py-0.5 text-[9px] bg-amber-100 text-amber-800 rounded-md font-extrabold uppercase border border-amber-200/60">Terbaru</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-center font-medium">
                                                {{ number_format($trxBulan, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 px-4 text-right font-black text-slate-900">
                                                Rp {{ number_format($omzetBulan, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 px-4 text-right font-medium text-slate-600">
                                                Rp {{ number_format($avgPerTrx, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($bulanLalu)
                                                    @if($diffPercent > 0)
                                                        <span class="inline-flex items-center gap-0.5 text-[11px] font-bold text-teal-700 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-md">
                                                            <svg class="w-3 h-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                            </svg>
                                                            +{{ number_format($diffPercent, 1) }}%
                                                        </span>
                                                    @elseif($diffPercent < 0)
                                                        <span class="inline-flex items-center gap-0.5 text-[11px] font-bold text-rose-600 bg-rose-50 border border-rose-100 px-2 py-0.5 rounded-md">
                                                            <svg class="w-3 h-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                                                            </svg>
                                                            {{ number_format($diffPercent, 1) }}%
                                                        </span>
                                                    @else
                                                        <span class="text-slate-400 text-[11px] font-medium">0%</span>
                                                    @endif
                                                @else
                                                    <span class="text-slate-400 text-[11px] font-normal">-</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <a href="{{ route('admin.history.week', ['month' => $monthVal, 'year' => $yearVal]) }}" 
                                                   class="inline-flex items-center gap-1 text-[11px] font-bold text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 border border-teal-200/60 px-2.5 py-1 rounded-lg transition-colors">
                                                    <span>Detail Minggu</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                @else
                    <!-- Tampilan Kosong -->
                    <div class="py-16 text-center">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-sm font-semibold text-slate-700">Belum ada data bulanan</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Data riwayat akan otomatis muncul setelah transaksi tercatat.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Script Chart.js -->
    @if(!empty($historyBulanan) && count($historyBulanan) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const canvas = document.getElementById('historyChart');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [
                            {
                                label: 'Total Omzet',
                                data: @json($chartOmzet),
                                borderColor: '#0d9488',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                pointBackgroundColor: '#0d9488',
                                pointRadius: 3,
                                pointHoverRadius: 6,
                                tension: 0.1,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Transaksi',
                                data: @json($chartTrx),
                                borderColor: '#f59e0b',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                pointBackgroundColor: '#f59e0b',
                                pointRadius: 3,
                                pointHoverRadius: 6,
                                tension: 0.1,
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
                                backgroundColor: '#0f766e',
                                titleFont: { size: 11, weight: 'bold' },
                                bodyFont: { size: 11 },
                                padding: 8,
                                cornerRadius: 6,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        let val = context.raw || 0;
                                        if (label === 'Total Omzet') {
                                            return label + ': Rp ' + new Intl.NumberFormat('id-ID').format(val);
                                        }
                                        return label + ': ' + val + ' Trx';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 10 }, color: '#64748b' }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                border: { display: false },
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    font: { size: 10 },
                                    color: '#64748b',
                                    callback: function(value) {
                                        if (value >= 1000000000) return (value / 1000000000).toFixed(1) + 'M';
                                        if (value >= 1000000) return (value / 1000000).toFixed(0) + 'Jt';
                                        if (value >= 1000) return (value / 1000).toFixed(0) + 'Rb';
                                        return value;
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

                document.getElementById('toggleOmzet')?.addEventListener('change', function(e) {
                    chart.setDatasetVisibility(0, e.target.checked);
                    chart.update();
                });

                document.getElementById('toggleTrx')?.addEventListener('change', function(e) {
                    chart.setDatasetVisibility(1, e.target.checked);
                    chart.update();
                });
            });
        </script>
    @endif

@endsection