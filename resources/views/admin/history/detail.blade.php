@extends('layouts.app')

@section('title', 'Detail Transaksi - POS')

@section('content')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman & Tombol Kembali -->
            <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h2 class="text-2xl font-black text-stone-900 tracking-tight">Detail Transaksi: <span class="text-teal-600">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span></h2>
                    <p class="text-xs text-stone-500 mt-1">Daftar seluruh struk transaksi yang tercatat pada tanggal ini.</p>
                </div>
                <a href="javascript:history.back()" class="px-4 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-2xl text-xs font-bold border border-stone-200/80 transition-all">
                    &larr; Kembali
                </a>
            </div>

            <div class="space-y-4">
                @forelse($transaksis as $trx)
                    <div class="bg-white border border-stone-200/80 p-6 rounded-3xl shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-stone-100 gap-2">
                            <div>
                                <span class="text-[11px] font-extrabold text-teal-600 uppercase tracking-wider">ID Transaksi: #{{ $trx->id }}</span>
                                <p class="text-xs text-stone-500 mt-0.5">Waktu: {{ $trx->created_at->format('H:i:s') }} WIB</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="text-xs font-bold text-stone-500">Total Belanja:</span>
                                <p class="text-sm font-black text-stone-900">Rp {{ number_format($trx->total_pembayaran ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Tabel Item Produk yang Dibeli dalam Transaksi Ini -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-stone-700">
                                <thead class="bg-stone-50 text-stone-500 uppercase tracking-wider">
                                    <tr>
                                        <th class="py-2.5 px-3 rounded-l-xl">Nama Produk</th>
                                        <th class="py-2.5 px-3">Harga Satuan</th>
                                        <th class="py-2.5 px-3">Kuantitas</th>
                                        <th class="py-2.5 px-3 rounded-r-xl text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @foreach($trx->itemPenjualans as $item)
                                        <tr>
                                            <td class="py-2.5 px-3 font-medium text-stone-900">{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                                            <td class="py-2.5 px-3">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                            <td class="py-2.5 px-3 font-bold text-stone-700">{{ $item->kuantitas }}</td>
                                            <td class="py-2.5 px-3 text-right font-bold text-teal-700">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-white rounded-3xl border border-stone-200/80 shadow-sm">
                        <p class="text-stone-500 text-xs font-medium">Tidak ada transaksi ditemukan pada tanggal ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection