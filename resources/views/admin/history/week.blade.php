@extends('layouts.app') 

@section('title', 'Riwayat Penjualan Mingguan - Toko Kelontong Zahir')

@section('content') 
    @include('layouts.navbar')

    <style>
        /* Menghilangkan panah bawaan HTML summary agar rapi */
        summary::-webkit-details-marker { display: none; }
        summary { list-style: none; }
    </style>

    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Wrapper Card -->
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm p-6 space-y-6">
                
                <!-- Header Tab Navigasi & Status -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('admin.history.index') }}" 
                           class="flex items-center gap-2 pb-2 text-xs font-semibold text-slate-400 hover:text-slate-600 border-b-2 border-transparent transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Bulanan
                        </a>
                        <a href="{{ route('admin.history.week') }}" 
                           class="flex items-center gap-2 pb-2 text-xs font-bold text-teal-700 border-b-2 border-teal-600 transition-all">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Mingguan
                        </a>
                    </div>

                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span>Rekapitulasi Total</span>
                        <span class="px-2.5 py-1 rounded-md bg-teal-50 text-teal-800 font-bold border border-teal-100">Semua Minggu</span>
                    </div>
                </div>

                @if(!empty($historyMingguan) && count($historyMingguan) > 0) 
                    @php 
                        $formatRingkas = function($nominal) { 
                            if ($nominal >= 1000000000) { 
                                return number_format($nominal / 1000000000, 1, ',', '.') . 'M'; 
                            } elseif ($nominal >= 1000000) { 
                                return number_format($nominal / 1000000, 1, ',', '.') . 'Jt'; 
                            } 
                            return number_format($nominal, 0, ',', '.'); 
                        }; 

                        $grandTotalOmzet = 0; 
                        $grandTotalTransaksi = 0; 
                        $penjualanTertinggi = 0; 

                        foreach($historyMingguan as $item) { 
                            $omzet = (float) ($item->total_omzet ?? 0); 
                            $trx = (int) ($item->total_transaksi ?? 0); 
                            $grandTotalOmzet += $omzet; 
                            $grandTotalTransaksi += $trx; 
                            if ($omzet > $penjualanTertinggi) { 
                                $penjualanTertinggi = $omzet; 
                            } 
                        } 

                        $totalMingguTercatat = count($historyMingguan); 
                        $rataRataMingguan = $totalMingguTercatat > 0 ? $grandTotalOmzet / $totalMingguTercatat : 0; 
                        $rataRataTrxMinggu = $totalMingguTercatat > 0 ? round($grandTotalTransaksi / $totalMingguTercatat) : 0; 
                        $rataRataPerTrx = $grandTotalTransaksi > 0 ? $grandTotalOmzet / $grandTotalTransaksi : 0; 

                        $historyForChart = is_array($historyMingguan) ? array_reverse($historyMingguan) : $historyMingguan->reverse(); 
                        $chartLabels = []; 
                        $chartOmzet = []; 
                        $chartTrx = []; 

                        foreach($historyForChart as $item) { 
                            $chartLabels[] = $item->label_minggu ?? ('Minggu ' . ($item->minggu_ke ?? '')); 
                            $chartOmzet[] = (float) ($item->total_omzet ?? 0); 
                            $chartTrx[] = (int) ($item->total_transaksi ?? 0); 
                        } 
                        $minWidthPx = max(100, $totalMingguTercatat * 80); 
                    @endphp

                    <!-- KPI Stats Header -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-teal-50/50 border border-teal-100 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-teal-800 uppercase tracking-wider">TOTAL OMZET</p>
                            <h2 class="text-xl font-black text-teal-900 mt-0.5">Rp {{ $formatRingkas($grandTotalOmzet) }}</h2>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">TOTAL TRANSAKSI</p>
                            <h2 class="text-xl font-black text-slate-800 mt-0.5">{{ number_format($grandTotalTransaksi, 0, ',', '.') }}</h2>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">RATA-RATA / MINGGU</p>
                            <h2 class="text-xl font-black text-slate-800 mt-0.5">Rp {{ $formatRingkas($rataRataMingguan) }}</h2>
                        </div>
                        <div class="bg-amber-50/70 border border-amber-200/60 p-4 rounded-xl">
                            <p class="text-[10px] font-extrabold text-amber-700 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> MINGGU AKTIF
                            </p>
                            <h2 class="text-xl font-black text-amber-900 mt-0.5 truncate">
                                {{ $historyMingguan[0]->label_minggu ?? 'Minggu Ini' }}
                            </h2>
                        </div>
                    </div>

                    <!-- Secondary Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-2">
                        <div class="bg-slate-50/80 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-slate-500">Penjualan Tertinggi</p>
                            <h3 class="text-base font-bold text-teal-700 mt-1">Rp {{ $formatRingkas($penjualanTertinggi) }}</h3>
                        </div>

                        <div class="bg-slate-50/80 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-slate-500">Rata-rata Transaksi</p>
                            <h3 class="text-base font-bold text-slate-800 mt-1">
                                {{ $rataRataTrxMinggu }} <span class="text-[11px] font-normal text-slate-400">trx/minggu</span>
                            </h3>
                        </div>

                        <div class="bg-slate-50/80 border border-slate-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-slate-500">Rata-rata / Transaksi</p>
                            <h3 class="text-base font-bold text-slate-800 mt-1">Rp {{ number_format($rataRataPerTrx, 0, ',', '.') }}</h3>
                        </div>

                        <div class="bg-amber-50/50 border border-amber-100 p-3.5 rounded-xl">
                            <p class="text-[11px] font-semibold text-amber-800">Total Minggu Tercatat</p>
                            <h3 class="text-base font-bold text-amber-900 mt-1">
                                {{ $totalMingguTercatat }} <span class="text-[11px] font-medium text-amber-600">Minggu</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="pt-2">
                        <div id="chartScrollContainer" class="w-full overflow-x-auto pb-2 custom-scrollbar">
                            <div class="relative h-64" style="min-width: max(100%, {{ $minWidthPx }}px);">
                                <canvas id="historyChart"></canvas>
                            </div>
                        </div>

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

                    <!-- Accordion Mingguan (Native HTML details/summary) -->
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-bold text-slate-800">Rincian Per Minggu</h3>
                            <span class="text-xs text-slate-400">Diurutkan dari minggu terbaru</span>
                        </div>

                        @foreach($historyMingguan as $index => $item) 
                            @php 
                                $omzetMinggu = (float) ($item->total_omzet ?? 0); 
                                $trxMinggu = (int) ($item->total_transaksi ?? 0); 
                                $avgTrxMinggu = $trxMinggu > 0 ? $omzetMinggu / $trxMinggu : 0; 

                                $mingguLalu = $historyMingguan[$index + 1] ?? null; 
                                $omzetLalu = $mingguLalu ? (float) ($mingguLalu->total_omzet ?? 0) : 0; 
                                $diffPercent = 0; 
                                if ($omzetLalu > 0) { 
                                    $diffPercent = (($omzetMinggu - $omzetLalu) / $omzetLalu) * 100; 
                                } 

                                $detailHarian = $item->detail_harian ?? []; 
                            @endphp

                            <!-- HANYA MINGGU PERTAMA ($loop->first) YANG MEMILIKI ATRIBUT open -->
                            <details {{ $loop->first ? 'open' : '' }} class="group border border-teal-100 rounded-xl overflow-hidden bg-white transition-all duration-200 hover:border-teal-200">
                                
                                <!-- Summary Header (Bisa diklik secara native oleh browser) -->
                                <summary class="p-4 bg-white hover:bg-teal-50/20 cursor-pointer flex items-center justify-between transition-colors select-none">
                                    
                                    <div class="flex items-center gap-3">
                                        <!-- Panah berputar otomatis menggunakan group-open:rotate-180 -->
                                        <svg class="w-4 h-4 text-teal-600 transition-transform duration-200 transform group-open:rotate-180"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>

                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-sm font-bold text-slate-800">
                                                    {{ $item->label_minggu ?? ('Minggu Ke-' . $item->minggu_ke) }}
                                                </h4>
                                                @if($loop->first)
                                                    <span class="px-2 py-0.5 text-[9px] font-extrabold bg-amber-100 text-amber-800 rounded-md uppercase border border-amber-200/60">Terbaru</span>
                                                @endif 
                                                @if(isset($item->rentang_tanggal))
                                                    <span class="text-xs text-slate-400 font-normal">({{ $item->rentang_tanggal }})</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                {{ $trxMinggu }} Transaksi &bull; Rata-rata/Trx: Rp {{ number_format($avgTrxMinggu, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right flex items-center gap-3">
                                        @if($mingguLalu) 
                                            @if($diffPercent > 0)
                                                <span class="hidden sm:inline-flex items-center gap-0.5 text-[11px] font-bold text-teal-700 bg-teal-50 border border-teal-100 px-2 py-0.5 rounded-md">
                                                    ▲ +{{ number_format($diffPercent, 1) }}%
                                                </span>
                                            @elseif($diffPercent < 0)
                                                <span class="hidden sm:inline-flex items-center gap-0.5 text-[11px] font-bold text-rose-600 bg-rose-50 border border-rose-100 px-2 py-0.5 rounded-md">
                                                    ▼ {{ number_format($diffPercent, 1) }}%
                                                </span>
                                            @endif 
                                        @endif
                                        <span class="text-sm font-black text-slate-900 block">
                                            Rp {{ number_format($omzetMinggu, 0, ',', '.') }}
                                        </span>
                                                     <a href="{{ route('admin.history.week.print', ['tahun' => $item->tahun, 'minggu' => $item->minggu_ke]) }}" target="_blank"
                                                         class="inline-flex items-center text-[10px] font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-slate-200 px-2 py-1 rounded-md transition-colors">
                                            Cetak
                                        </a>
                                    </div>
                                </summary>

                                <!-- Body Accordion (Detail Harian) -->
                                <div class="border-t border-slate-100 bg-slate-50/50 p-4">
                                    @if(count($detailHarian) > 0)
                                        <div class="overflow-x-auto rounded-xl border border-slate-200/60 bg-white">
                                            <table class="min-w-[760px] w-full text-left text-xs border-collapse">
                                                <thead>
                                                    <tr class="bg-teal-50/60 border-b border-teal-100 text-teal-900 font-bold uppercase tracking-wider">
                                                        <th class="py-2.5 px-4">TANGGAL</th>
                                                        <th class="py-2.5 px-4 text-center">JUMLAH TRANSAKSI</th>
                                                        <th class="py-2.5 px-4 text-right">OMZET HARIAN</th>
                                                        <th class="py-2.5 px-4 text-right">RATA-RATA / TRX</th>
                                                        <th class="py-2.5 px-4 text-center">AKSI</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-100">
                                                    @foreach($detailHarian as $day) 
                                                        @php 
                                                            $omzetHari = (float) ($day->total_omzet ?? 0); 
                                                            $trxHari = (int) ($day->total_transaksi ?? 0); 
                                                            $avgHari = $trxHari > 0 ? $omzetHari / $trxHari : 0; 
                                                            $tglRaw = $day->tanggal ?? null; 
                                                        @endphp
                                                        <tr class="hover:bg-teal-50/20 transition-colors">
                                                            <td class="py-2.5 px-4 font-bold text-slate-700">
                                                                {{ \Carbon\Carbon::parse($tglRaw)->translatedFormat('l, d M Y') }}
                                                            </td>
                                                            <td class="py-2.5 px-4 text-center text-slate-600 font-medium">
                                                                {{ number_format($trxHari, 0, ',', '.') }}
                                                            </td>
                                                            <td class="py-2.5 px-4 text-right font-black text-slate-800">
                                                                Rp {{ number_format($omzetHari, 0, ',', '.') }}
                                                            </td>
                                                            <td class="py-2.5 px-4 text-right text-slate-500 font-medium">
                                                                Rp {{ number_format($avgHari, 0, ',', '.') }}
                                                            </td>
                                                            <td class="py-2.5 px-4 text-center">
                                                                @if($tglRaw)
                                                                    <a href="{{ route('admin.history.date', ['tanggal' => $tglRaw]) }}" 
                                                                       class="inline-flex items-center gap-1 text-[10px] font-bold text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 border border-teal-200/60 px-2 py-1 rounded-md transition-colors">
                                                                        <span>Lihat Transaksi</span>
                                                                    </a>
                                                                @else 
                                                                    <span class="text-slate-300">-</span> 
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-xs text-slate-400 text-center py-4">
                                            Tidak ada rincian harian untuk minggu ini.
                                        </p>
                                    @endif
                                </div>

                            </details>
                        @endforeach
                    </div>

                @else
                    <div class="py-16 text-center">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-sm font-semibold text-slate-700">Belum ada data riwayat mingguan</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Data akan muncul secara otomatis setelah transaksi tercatat.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Script Chart.js & Checkbox Toggle -->
    @if(!empty($historyMingguan) && count($historyMingguan) > 0)
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

                // Toggle visibility dataset via checkbox
                const toggleOmzet = document.getElementById('toggleOmzet');
                const toggleTrx = document.getElementById('toggleTrx');

                if (toggleOmzet) {
                    toggleOmzet.addEventListener('change', function() {
                        chart.setDatasetVisibility(0, this.checked);
                        chart.update();
                    });
                }

                if (toggleTrx) {
                    toggleTrx.addEventListener('change', function() {
                        chart.setDatasetVisibility(1, this.checked);
                        chart.update();
                    });
                }
            });
        </script>
    @endif
@endsection