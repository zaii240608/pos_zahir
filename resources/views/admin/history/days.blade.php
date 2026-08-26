@extends('layouts.app')

@section('title', 'Detail Transaksi - POS')

@section('content')

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman & Tombol Kembali -->
            <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-teal-100 shadow-sm">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-amber-500 rounded-full inline-block"></span>
                        Detail Transaksi {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </h2>
                    <p class="text-xs text-slate-500 mt-1 pl-4">Daftar seluruh struk transaksi yang tercatat pada tanggal ini.</p>
                </div>
                <a href="javascript:history.back()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold border border-slate-200/80 transition-all flex items-center gap-1.5">
                    &larr; Kembali
                </a>
            </div>

            <div class="space-y-4">
                @forelse($transaksis as $trx)
                    <div class="bg-white border border-teal-100 p-6 rounded-2xl shadow-sm space-y-4 hover:border-teal-200 transition-all">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-slate-100 gap-2">
                            <div>
                                <span class="text-[11px] font-extrabold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-md border border-teal-100 uppercase tracking-wider">ID Transaksi: #{{ $trx->id }}</span>
                                <p class="text-xs text-slate-500 mt-2">Waktu: {{ $trx->created_at->format('H:i:s') }} WIB</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="text-xs font-bold text-slate-400">Total Belanja:</span>
                                <p class="text-base font-black text-amber-600">Rp {{ number_format($trx->total_pembayaran ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Tabel Item Produk yang Dibeli dalam Transaksi Ini -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-slate-700">
                                <thead class="bg-teal-50/70 text-teal-900 uppercase tracking-wider font-bold">
                                    <tr>
                                        <th class="py-2.5 px-3 rounded-l-lg">Nama Produk</th>
                                        <th class="py-2.5 px-3">Harga Satuan</th>
                                        <th class="py-2.5 px-3">Kuantitas</th>
                                        <th class="py-2.5 px-3 rounded-r-lg text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($trx->itemPenjualans as $item)
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                                            <td class="py-2.5 px-3 text-slate-600">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                            <td class="py-2.5 px-3 font-bold text-slate-700">{{ $item->kuantitas }}</td>
                                            <td class="py-2.5 px-3 text-right font-bold text-teal-700">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-white rounded-2xl border border-slate-200/80 shadow-sm">
                        <p class="text-slate-400 text-xs font-medium">Tidak ada transaksi ditemukan pada tanggal ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection