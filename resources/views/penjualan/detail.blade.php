@extends('layouts.app')
@section('title', 'Detail Transaksi #'.$penjualan->id)

@section('content')
<!-- Wrapper Navbar sembunyi total saat cetak -->
<div class="print:hidden">
    @include('layouts.navbar')
</div>

<div class="min-h-screen bg-stone-100 py-8 print:bg-white print:min-h-0 print:py-0 print:p-0">
    <div class="max-w-md mx-auto px-4 print:p-0 print:max-w-full">
        
        <!-- Action Bar (Sembunyi saat cetak) -->
        <div class="mb-6 flex items-center justify-between gap-3 print:hidden">
            <a href="{{ route('penjualan.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-stone-200 text-stone-700 text-xs font-bold shadow-sm hover:bg-stone-50 transition active:scale-95"> 
                Kembali
            </a>

            <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold shadow-md shadow-teal-700/20 transition active:scale-95 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Struk
            </button>
        </div>

        <!-- Kartu Struk (Receipt Card) -->
        <div class="receipt-card bg-white rounded-3xl border border-stone-200/80 shadow-xl overflow-hidden print:shadow-none print:border-none print:rounded-none">
            
            <!-- Banner Status (Sembunyi saat cetak) -->
            <div class="bg-teal-950 px-6 py-3 flex items-center justify-between text-white print:hidden">
                <span class="text-xs font-bold text-amber-300 tracking-wider uppercase">Status Transaksi</span>
                @if(in_array(strtoupper($penjualan->status), ['COMPLETED', 'SELESAI']))
                    <span class="px-3 py-1 text-xs font-black rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/30">
                        SELESAI
                    </span>
                @else
                    <span class="px-3 py-1 text-xs font-black rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        {{ strtoupper($penjualan->status) }}
                    </span>
                @endif
            </div>

            <div class="p-6 space-y-6 print:p-4">
                
                <!-- Header Toko & Nota -->
                <div class="text-center space-y-1 pb-4 border-b-2 border-dashed border-stone-300 print:border-black">
                    <h2 class="text-2xl font-black text-stone-900 tracking-tight uppercase print:text-black">SISTEM POS</h2>
                    <p class="text-xs font-bold text-stone-500 print:text-stone-800">Struk Bukti Pembayaran</p>
                    <div class="pt-2 flex items-center justify-center gap-2 text-sm font-black text-stone-800 print:text-black">
                        <span>#{{ $penjualan->id }}</span>
                        <span>•</span>
                        <span>{{ $penjualan->created_at ? $penjualan->created_at->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                </div>

                <!-- Info Metadata -->
                <div class="grid grid-cols-2 gap-3 text-xs py-2 border-b-2 border-dashed border-stone-300 print:border-black">
                    <div>
                        <span class="text-stone-400 block text-[10px] uppercase font-black print:text-stone-600">Kasir</span>
                        <span class="font-black text-stone-900 text-sm print:text-black">{{ $penjualan->user->name ?? 'Admin' }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-stone-400 block text-[10px] uppercase font-black print:text-stone-600">Metode Bayar</span>
                        <span class="font-black text-stone-900 text-sm uppercase print:text-black">{{ $penjualan->metode_pembayaran ?? 'CASH' }}</span>
                    </div>
                </div>

                <!-- Item Rincian Produk -->
                <div class="space-y-3">
                    <p class="text-xs font-black uppercase tracking-wider text-stone-400 print:text-stone-700">Rincian Pembelian</p>
                    
                    <div class="space-y-3">
                        @forelse($penjualan->items as $item)
                            <div class="flex justify-between items-start text-xs gap-3 print:text-sm">
                                <div class="grow min-w-0">
                                    <p class="font-black text-stone-900 text-sm print:text-black leading-tight">{{ $item->produk->nama ?? 'Produk Terhapus' }}</p>
                                    <p class="text-xs font-bold text-stone-500 print:text-stone-700 mt-0.5">
                                        {{ $item->kuantitas ?? $item->jumlah }} x Rp {{ number_format($item->harga_satuan ?? $item->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="font-black text-stone-900 text-sm shrink-0 print:text-black">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-xs font-bold text-stone-400 py-4">Belum ada item pada transaksi ini.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Total & Perhitungan Pembayaran -->
                <div class="pt-4 border-t-4 border-stone-900 space-y-2 print:border-black">
                    <div class="flex justify-between items-center text-base font-black text-stone-900 print:text-black">
                        <span>TOTAL</span>
                        <span class="text-xl font-black">
                            Rp {{ number_format($penjualan->total_harga ?? $penjualan->items->sum('subtotal'), 0, ',', '.') }}
                        </span>
                    </div>

                    @if(isset($penjualan->bayar))
                    <div class="flex justify-between items-center text-xs font-bold text-stone-700 print:text-black print:text-sm pt-1">
                        <span>Bayar / Tunai</span>
                        <span class="font-black">
                            Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif

                    @if(isset($penjualan->kembalian))
                    <div class="flex justify-between items-center text-xs font-bold text-stone-700 print:text-black print:text-sm">
                        <span>Kembali</span>
                        <span class="font-black">
                            Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Footer Struk -->
                <div class="text-center pt-5 border-t-2 border-dashed border-stone-300 space-y-1 print:border-black">
                    <p class="text-sm font-black text-stone-900 print:text-black">Terima Kasih atas Kunjungan Anda!</p>
                    <p class="text-[10px] font-bold text-stone-400 print:text-stone-700">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Styling khusus Mode Cetak (Dibuat Lebih Besar & Tebal) -->
<style>
    @media print {
        @page {
            size: auto; /* Mengikuti ukuran kertas printer default */
            margin: 5mm;
        }
        
        body {
            background-color: white !important;
            color: black !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 14px !important;
        }

        /* Sembunyi elemen navigasi */
        nav, header, footer, .print\:hidden {
            display: none !important;
        }

        /* Paksa area cetak memenuhi lebar struk dengan jelas */
        .receipt-card {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 auto !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }

        /* Paksa elemen garis agar tebal dan tercetak jelas */
        .border-dashed {
            border-style: dashed !important;
        }
    }
</style>
@endsection