@extends('layouts.app')

@section('title', 'Detail Penjualan ' . $namaBulan)

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <a href="{{ route('admin.history.index') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900">&larr; Kembali ke riwayat</a>
                        <h1 class="text-2xl font-black text-slate-900 mt-2">Penjualan {{ $namaBulan }}</h1>
                        <p class="text-xs text-slate-500 mt-1">Ringkasan penjualan harian pada periode yang dipilih.</p>
                    </div>
                    <a href="{{ route('admin.history.month.print', ['tahun' => $tahun, 'bulan' => $bulan]) }}" target="_blank" class="inline-flex items-center justify-center bg-teal-700 hover:bg-teal-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors">Cetak Laporan</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-teal-50 border border-teal-100 rounded-xl p-4"><p class="text-[10px] font-bold uppercase text-teal-700">Total Omzet</p><p class="text-lg font-black text-teal-950 mt-1">Rp {{ number_format($rekapBulan->total_omzet, 0, ',', '.') }}</p></div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4"><p class="text-[10px] font-bold uppercase text-slate-500">Transaksi</p><p class="text-lg font-black text-slate-900 mt-1">{{ number_format($rekapBulan->total_transaksi, 0, ',', '.') }}</p></div>
                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-4"><p class="text-[10px] font-bold uppercase text-amber-700">Produk Terjual</p><p class="text-lg font-black text-amber-950 mt-1">{{ number_format($rekapBulan->total_produk_terjual, 0, ',', '.') }}</p></div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-[620px] w-full text-left text-xs">
                        <thead class="bg-teal-50 text-teal-950 uppercase tracking-wider"><tr><th class="p-3">Tanggal</th><th class="p-3 text-center">Transaksi</th><th class="p-3 text-right">Omzet</th><th class="p-3 text-center">Aksi</th></tr></thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($historyHarian as $hari)
                                <tr class="hover:bg-slate-50"><td class="p-3 font-bold">{{ \Carbon\Carbon::parse($hari->tanggal)->translatedFormat('l, d F Y') }}</td><td class="p-3 text-center">{{ $hari->total_transaksi }}</td><td class="p-3 text-right font-black">Rp {{ number_format($hari->total_omzet, 0, ',', '.') }}</td><td class="p-3 text-center"><a href="{{ route('admin.history.date', ['tanggal' => $hari->tanggal]) }}" class="text-teal-700 font-bold hover:underline">Detail</a></td></tr>
                            @empty
                                <tr><td colspan="4" class="p-8 text-center text-slate-400">Belum ada transaksi pada bulan ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
