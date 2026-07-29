@extends('layouts.app')
@section('title', 'Detail Transaksi #'.$penjualan->id)

@section('content')
@include('layouts.navbar')

<div class="min-h-screen bg-amber-50/40 py-8 print:bg-white print:py-0">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 print:p-0 print:max-w-full">
        
        <!-- Kartu Utama Detail -->
        <div class="bg-white rounded-3xl border border-amber-200/60 shadow-sm p-6 sm:p-8 print:border-none print:shadow-none print:p-0">
            
            <!-- Header Halaman -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-6 border-b border-amber-100 print:border-stone-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-700 shadow-sm print:hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 text-[10px] font-black uppercase bg-teal-100 text-teal-900 rounded-full border border-teal-200 print:hidden">
                                Rincian Nota
                            </span>
                            <h1 class="text-xl font-extrabold text-teal-950 print:text-black">
                                Transaksi <span class="text-rose-500 print:text-black">#{{ $penjualan->id }}</span>
                            </h1>
                        </div>
                        <p class="text-xs text-stone-500 mt-0.5 print:hidden">Informasi lengkap rincian produk dan status pembayaran.</p>
                    </div>
                </div>

                <!-- Tombol Aksi (Sembunyi saat cetak) -->
                <div class="flex items-center gap-2 print:hidden">
                    <button onclick="window.print()" 
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-2xl transition active:scale-95 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Cetak Struk</span>
                    </button>

                    <a href="{{ route('penjualan.index') }}" 
                       class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold rounded-2xl border border-stone-200 transition active:scale-95 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            <!-- Informasi Ringkas Transaksi (Grid 4 Kolom) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 bg-amber-50/40 p-4 rounded-2xl border border-amber-200/60 print:bg-transparent print:border-none print:p-0 print:mb-4">
                <div>
                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider print:text-stone-600">Tanggal Transaksi</p>
                    <p class="font-bold text-stone-800 text-xs mt-1">
                        {{ $penjualan->created_at ? $penjualan->created_at->format('d/m/Y H:i') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider print:text-stone-600">Kasir</p>
                    <p class="font-bold text-stone-800 text-xs mt-1">
                        {{ $penjualan->user->name ?? 'Admin' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider print:text-stone-600">Metode Pembayaran</p>
                    <p class="font-bold text-teal-900 text-xs mt-1 uppercase print:text-stone-800">
                        {{ $penjualan->metode_pembayaran ?? 'CASH' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-extrabold text-stone-400 uppercase tracking-wider print:text-stone-600">Status</p>
                    <div class="mt-1">
                        @if($penjualan->status == 'COMPLETED' || $penjualan->status == 'SELESAI')
                            <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-extrabold rounded-full bg-teal-100 text-teal-800 border border-teal-200 print:bg-transparent print:border-none print:p-0">
                                SELESAI
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-extrabold rounded-full bg-amber-100 text-amber-800 border border-amber-200 print:bg-transparent print:border-none print:p-0">
                                {{ $penjualan->status }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bagian Daftar Item -->
            <h2 class="text-sm font-extrabold text-teal-950 mb-3 flex items-center gap-2 print:text-black">
                <svg class="w-4 h-4 text-teal-600 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Daftar Item Dibeli
            </h2>

            <div class="overflow-x-auto rounded-2xl border border-amber-200/80 mb-6 print:border-stone-300">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-stone-50 border-b border-amber-100 text-stone-500 print:border-stone-300">
                            <th class="p-3 font-bold text-[10px] uppercase print:text-black">Nama Produk</th>
                            <th class="p-3 font-bold text-[10px] uppercase print:text-black">Harga Satuan</th>
                            <th class="p-3 font-bold text-[10px] uppercase text-center print:text-black">Kuantitas</th>
                            <th class="p-3 font-bold text-[10px] uppercase text-right print:text-black">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100/60 bg-white print:divide-stone-200">
                        @forelse($penjualan->items as $item)
                            <tr class="hover:bg-amber-50/30 transition-colors">
                                <td class="p-3 text-stone-800 font-bold">
                                    {{ $item->produk->nama ?? 'Produk Terhapus' }}
                                </td>
                                <td class="p-3 text-stone-600">
                                    Rp {{ number_format($item->harga_satuan ?? $item->harga, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-stone-800 font-bold text-center">
                                    {{ $item->kuantitas ?? $item->jumlah }}
                                </td>
                                <td class="p-3 text-right text-teal-950 font-extrabold print:text-black">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-stone-400 py-8 text-xs">
                                    Belum ada item pada transaksi ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan Total & Pembayaran -->
            <div class="flex justify-end border-t border-amber-100 pt-5 print:border-stone-300">
                <div class="w-full sm:w-80 bg-amber-50/60 p-4 rounded-2xl border border-amber-200/60 space-y-2 print:bg-transparent print:border-none print:p-0">

                    @if(isset($penjualan->bayar))
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-stone-500 font-medium">Tunai / Bayar</span>
                        <span class="font-bold text-stone-800">
                            Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif

                    @if(isset($penjualan->kembalian))
                    <div class="flex justify-between items-center text-xs pb-2 border-b border-amber-200/60 print:border-stone-300">
                        <span class="text-stone-500 font-medium">Kembali</span>
                        <span class="font-bold text-stone-800">
                            Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center pt-1">
                        <span class="text-xs font-bold text-stone-600 uppercase tracking-wider">Total Pembayaran: </span>
                        <span class="text-xl font-black text-teal-900 print:text-black">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection