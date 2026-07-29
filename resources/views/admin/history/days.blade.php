@extends('layouts.app')

@section('title', 'Riwayat Harian - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Header Halaman & Tombol Kembali -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h2 class="text-2xl font-black text-stone-900 tracking-tight">Riwayat Harian <span class="text-teal-600">{{ $namaBulan }}</span></h2>
                    <p class="text-xs text-stone-500 mt-1">Pilih tanggal tertentu untuk melihat daftar transaksi detail.</p>
                </div>
                <a href="{{ route('admin.history.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-2xl text-xs font-bold border border-stone-200/80 transition-all self-start md:self-auto">
                    &larr; Kembali ke Daftar Bulan
                </a>
            </div>

            <!-- Grid Riwayat Harian -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($historyHarian as $hari)
                    <div class="bg-white border border-stone-200/80 p-6 rounded-3xl shadow-sm flex flex-col justify-between space-y-5 hover:shadow-md transition duration-200">
                        <div>
                            <span class="text-[11px] font-extrabold text-teal-600 uppercase tracking-wider">
                                {{ \Carbon\Carbon::parse($hari->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                            <div class="mt-3 space-y-2 text-xs font-medium text-stone-500 border-t border-stone-100 pt-4">
                                <p class="flex justify-between items-center">
                                    <span>Omzet Harian:</span> 
                                    <span class="text-teal-700 font-black text-sm">Rp {{ number_format($hari->total_omzet, 0, ',', '.') }}</span>
                                </p>
                                <p class="flex justify-between items-center">
                                    <span>Total Transaksi:</span> 
                                    <span class="text-stone-900 font-bold">{{ $hari->total_transaksi }} Transaksi</span>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.history.date', $hari->tanggal) }}" 
                           class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-extrabold rounded-2xl text-center text-xs transition duration-200 block shadow-sm shadow-teal-600/20">
                            Lihat Detail Transaksi
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-stone-200/80 shadow-sm">
                        <svg class="w-10 h-10 mx-auto mb-2 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-stone-500 text-xs font-medium">Tidak ada data transaksi di bulan ini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection