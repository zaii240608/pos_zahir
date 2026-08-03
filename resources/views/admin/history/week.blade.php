@extends('layouts.app')

@section('title', 'Riwayat Penjualan Mingguan - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-50/50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(!empty($historyMingguan) && count($historyMingguan) > 0)
                @php
                    // Hitung Grand Total & Statistik Utama
                    $grandTotalOmzet = 0;
                    $grandTotalTransaksi = 0;

                    foreach($historyMingguan as $item) {
                        $omzet = (float) ($item->total_omzet ?? 0);
                        $transaksi = (int) ($item->total_transaksi ?? 0);

                        $grandTotalOmzet += $omzet;
                        $grandTotalTransaksi += $transaksi;
                    }

                    $totalData = count($historyMingguan);
                    $rataRataMingguan = $totalData > 0 ? $grandTotalOmzet / $totalData : 0;
                    $minWidthPx = max(100, $totalData * 120);

                    // Reorder data khusus grafik (lama ke baru)
                    $historyForChart = is_array($historyMingguan) 
                        ? array_reverse($historyMingguan) 
                        : $historyMingguan->reverse();

                    $chartLabels = [];
                    $chartOmzet = [];
                    $chartTransaksi = [];

                    foreach($historyForChart as $item) {
                        $chartLabels[] = $item->label_minggu ?? ('Minggu Ke-' . $item->minggu_ke);
                        $chartOmzet[] = (float) ($item->total_omzet ?? 0);
                        $chartTransaksi[] = (int) ($item->total_transaksi ?? 0);
                    }
                @endphp

                <!-- Top Bar: Tab Switcher & Status -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-stone-200/80 shadow-xs">
                    <!-- Tab Switcher Bulanan / Mingguan -->
                    <div class="flex items-center gap-6 text-sm font-bold">
                        <a href="{{ route('admin.history.index') }}" 
                           class="flex items-center gap-2 text-stone-400 hover:text-stone-700 transition-colors pb-1 border-b-2 border-transparent">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Bulanan
                        </a>
                        <a href="{{ route('admin.history.week') }}" 
                           class="flex items-center gap-2 text-rose-500 pb-1 border-b-2 border-rose-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Mingguan
                        </a>
                    </div>

                    <!-- Pill Badge Kanan -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-stone-400">Rekapitulasi Total</span>
                        <span class="px-3 py-1 bg-stone-100 text-stone-700 font-bold rounded-lg text-xs border border-stone-200/60">
                            Semua Minggu
                        </span>
                    </div>
                </div>

                <!-- 1 Single Card Utama berisi 4 Item/Kolom -->
                <div class="bg-white rounded-3xl p-6 border border-stone-200/80 shadow-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 divide-y sm:divide-y-0 sm:divide-x divide-stone-100">
                        
                        <!-- Item 1: TOTAL OMZET -->
                        <div class="flex items-center justify-between sm:pr-4 pt-2 sm:pt-0">
                            <div>
                                <p class="text-[11px] font-bold text-stone-400 uppercase tracking-wider">TOTAL OMZET</p>
                                <h3 class="text-2xl font-extrabold text-stone-900 mt-1">Rp {{ number_format($grandTotalOmzet, 0, ',', '.') }}</h3>
                                <p class="text-xs text-stone-400 font-medium mt-1">Rp {{ number_format($grandTotalOmzet, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Item 2: TOTAL TRANSAKSI -->
                        <div class="flex items-center justify-between pt-4 sm:pt-0 sm:px-4">
                            <div>
                                <p class="text-[11px] font-bold text-stone-400 uppercase tracking-wider">TOTAL TRANSAKSI</p>
                                <h3 class="text-2xl font-extrabold text-stone-900 mt-1">{{ number_format($grandTotalTransaksi, 0, ',', '.') }}</h3>
                                <p class="text-xs text-stone-400 font-medium mt-1">Transaksi Tercatat</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Item 3: RATA-RATA / MINGGU -->
                        <div class="flex items-center justify-between pt-4 sm:pt-0 sm:px-4">
                            <div>
                                <p class="text-[11px] font-bold text-stone-400 uppercase tracking-wider">RATA-RATA / MINGGU</p>
                                <h3 class="text-2xl font-extrabold text-stone-900 mt-1">Rp {{ number_format($rataRataMingguan, 0, ',', '.') }}</h3>
                                <p class="text-xs text-stone-400 font-medium mt-1">Omzet per Pekan</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Item 4: TOTAL MINGGU -->
                        <div class="flex items-center justify-between pt-4 sm:pt-0 sm:pl-4">
                            <div>
                                <p class="text-[11px] font-bold text-stone-400 uppercase tracking-wider">TOTAL MINGGU</p>
                                <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $totalData }} Minggu</h3>
                                <p class="text-xs text-stone-400 font-medium mt-1">Periode Aktif</p>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Container Chart -->
                <div class="bg-white rounded-3xl border border-stone-200/80 p-6 shadow-xs">
                    <div id="chartScrollContainer" class="w-full overflow-x-auto pb-2 custom-scrollbar">
                        <div class="relative h-72" style="min-width: max(100%, {{ $minWidthPx }}px);">
                            <canvas id="weekChart"></canvas>
                        </div>
                    </div>

                    <!-- Legend bawah Grafik -->
                    <div class="flex items-center justify-end gap-6 text-xs font-medium text-stone-600 mt-4 pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked disabled class="rounded text-sky-500 focus:ring-0 w-3.5 h-3.5">
                            <span class="w-2.5 h-2.5 rounded-xs bg-sky-500"></span> Total Omzet
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked disabled class="rounded text-cyan-400 focus:ring-0 w-3.5 h-3.5">
                            <span class="w-2.5 h-2.5 rounded-xs bg-cyan-400"></span> Transaksi
                        </label>
                    </div>
                </div>

                <!-- Rincian Minggu & Hari (Accordion) -->
                <div class="space-y-3">
                    <h2 class="text-base font-bold text-stone-900 tracking-tight my-4">Rincian Per Minggu</h2>

                    @foreach($historyMingguan as $index => $item)
                        <details class="group bg-white rounded-2xl border border-stone-200/80 shadow-xs overflow-hidden transition-all duration-200" {{ $loop->first ? 'open' : '' }}>
                            
                            <!-- Header Accordion -->
                            <summary class="flex items-center justify-between p-5 cursor-pointer select-none hover:bg-stone-50/50 transition-colors list-none [&::-webkit-details-marker]:hidden">
                                <div>
                                    <h3 class="text-base font-extrabold text-stone-900">
                                        {{ $item->label_minggu ?? ('Minggu Ke-' . $item->minggu_ke) }}
                                    </h3>
                                    @if(!empty($item->rentang_tanggal))
                                        <p class="text-[11px] text-stone-400 font-medium mt-0.5">{{ $item->rentang_tanggal }}</p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Transaksi</p>
                                        <p class="text-xs font-bold text-stone-700">{{ number_format($item->total_transaksi ?? 0) }} trx</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Total Omzet</p>
                                        <p class="text-sm font-black text-rose-500">Rp {{ number_format($item->total_omzet ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="w-8 h-8 rounded-xl bg-stone-100 flex items-center justify-center text-stone-400 group-open:rotate-180 group-open:bg-rose-50 group-open:text-rose-500 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </summary>

                            <!-- Detail Harian -->
                            @if(!empty($item->detail_harian) && count($item->detail_harian) > 0)
                                <div class="px-5 pb-5 pt-3 border-t border-stone-100 bg-stone-50/30">
                                    <p class="text-[11px] font-bold text-stone-400 uppercase tracking-wider mb-2.5">Rincian Penjualan Harian</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
                                        @foreach($item->detail_harian as $hari)
                                            <a href="{{ route('admin.history.date', $hari->tanggal) }}" 
                                               class="group/card relative flex flex-col justify-between p-3 bg-white border border-stone-200/80 rounded-xl hover:border-rose-400 hover:shadow-xs hover:-translate-y-0.5 transition-all duration-200 cursor-pointer overflow-hidden">
                                                
                                                <div class="absolute top-0 left-0 right-0 h-1 bg-rose-500 opacity-0 group-hover/card:opacity-100 transition-opacity"></div>

                                                <div>
                                                    <div class="flex items-center justify-between mb-1">
                                                        <span class="text-[10px] font-bold text-stone-400 group-hover/card:text-rose-500 uppercase transition-colors">
                                                            {{ \Carbon\Carbon::parse($hari->tanggal)->locale('id')->translatedFormat('D') }}
                                                        </span>
                                                        <span class="text-[10px] font-semibold text-stone-500 bg-stone-100 group-hover/card:bg-rose-50 group-hover/card:text-rose-600 px-1.5 py-0.5 rounded-md transition-colors">
                                                            {{ \Carbon\Carbon::parse($hari->tanggal)->format('d/m') }}
                                                        </span>
                                                    </div>

                                                    <div class="my-1">
                                                        <p class="text-[11px] font-black text-stone-800 group-hover/card:text-rose-600 transition-colors">
                                                            Rp {{ number_format($hari->total_omzet ?? 0, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="pt-1.5 border-t border-stone-100 flex items-center justify-between text-[10px] text-stone-400 group-hover/card:text-rose-500 transition-colors">
                                                    <span>{{ $hari->total_transaksi ?? 0 }} trx</span>
                                                    <svg class="w-3 h-3 transform -translate-x-1 opacity-0 group-hover/card:translate-x-0 group-hover/card:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </details>
                    @endforeach
                </div>

            @else
                <!-- State Kosong -->
                <div class="py-16 text-center bg-white rounded-2xl border border-stone-200/80 shadow-xs">
                    <svg class="w-12 h-12 mx-auto mb-3 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-base font-bold text-stone-800">Belum ada data mingguan</h3>
                    <p class="text-stone-400 text-xs mt-1">Data rekap mingguan akan otomatis terisi dari transaksi penjualan.</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Chart.js Script -->
    @if(!empty($historyMingguan) && count($historyMingguan) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const weekCanvas = document.getElementById('weekChart');
                if (!weekCanvas) return;

                const ctx = weekCanvas.getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [
                            {
                                label: 'Total Transaksi (trx)',
                                data: @json($chartTransaksi),
                                borderColor: '#38bdf8',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.2,
                                yAxisID: 'y1',
                                pointBackgroundColor: '#38bdf8',
                                pointRadius: 4,
                                order: 2
                            },
                            {
                                label: 'Total Omzet (Rp)',
                                data: @json($chartOmzet),
                                borderColor: '#0284c7',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.2,
                                yAxisID: 'y',
                                pointBackgroundColor: '#0284c7',
                                pointRadius: 4,
                                order: 1
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
                                backgroundColor: '#1c1917',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 13 },
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        
                                        if (context.dataset.yAxisID === 'y') {
                                            label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw || 0);
                                        } else {
                                            label += (context.raw || 0) + ' Transaksi';
                                        }
                                        return label;
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
                                type: 'linear',
                                display: true,
                                position: 'left',
                                border: { dash: [4, 4] },
                                grid: { color: '#f5f5f4' },
                                ticks: {
                                    font: { size: 11 },
                                    color: '#78716c',
                                    callback: function(value) {
                                        if (value >= 1000000) return (value / 1000000).toFixed(1) + 'Jt';
                                        if (value >= 1000) return (value / 1000).toFixed(0) + 'Rb';
                                        return value;
                                    }
                                }
                            },
                            y1: {
                                display: false
                            }
                        }
                    }
                });

                setTimeout(() => {
                    const scrollContainer = document.getElementById('chartScrollContainer');
                    if (scrollContainer) scrollContainer.scrollLeft = scrollContainer.scrollWidth;
                }, 100);
            });
        </script>
    @endif

@endsection