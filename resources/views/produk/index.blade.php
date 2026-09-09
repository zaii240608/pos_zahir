@extends('layouts.app')

@section('title', 'Daftar Produk - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div id="success-alert" class="flex items-center justify-between gap-3 bg-teal-500/10 border border-teal-500/20 text-teal-800 px-5 py-4 rounded-3xl shadow-xs transition-opacity duration-500">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 bg-teal-500/20 text-teal-700 rounded-xl">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="dismissAlert('success-alert')" class="text-teal-600 hover:text-teal-800 p-1 rounded-lg hover:bg-teal-500/10 transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Clean Header Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Produk POS</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Kelola katalog produk, stok, dan harga penjualan toko Anda</p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('produk.create') }}" 
                       class="inline-flex items-center justify-center gap-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-sm hover:shadow transition-all duration-200 active:scale-95 border border-amber-300">
                        <span>Tambah Produk</span>
                    </a>
                </div>
            </div>

            <!-- Tabel Daftar Produk Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-black uppercase tracking-wider text-slate-700">Katalog Produk</h2>
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-[760px] w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-200/80 text-slate-600">
                                <th class="p-4 font-black uppercase tracking-wider w-12 text-center">#</th>
                                <th class="p-4 font-black uppercase tracking-wider w-16">Foto</th>
                                <th class="p-4 font-black uppercase tracking-wider">Nama Produk</th>
                                <th class="p-4 font-black uppercase tracking-wider">Jenis Produk</th>
                                <th class="p-4 font-black uppercase tracking-wider">Harga Jual</th>
                                <th class="p-4 font-black uppercase tracking-wider">Stok</th>
                                <th class="p-4 font-black uppercase tracking-wider text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                            @forelse($produks as $index => $produk)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-4 text-center font-bold text-slate-500">
                                        {{ $produks->firstItem() + $index }}
                                    </td>
                                    <td class="p-4">
                                        @if($produk->foto)
                                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-10 h-10 object-cover rounded-xl border border-slate-200/80 shadow-2xs">
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-400 text-[10px] font-bold">
                                                N/A
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 font-bold text-slate-900">
                                        {{ $produk->nama }}
                                    </td>
                                    <td class="p-4">
                                        @if($produk->jenis)
                                                {{ $produk->jenis->nama_jenis }}
                                        @elseif($produk->nama_jenis)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[11px] font-bold bg-teal-500/10 text-teal-700 border border-teal-500/20">
                                                {{ \App\Models\Jenis::find($produk->nama_jenis)?->nama_jenis ?? '-' }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-black whitespace-nowrap">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        @if($produk->stok <= 5)
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span> 
                                                {{ $produk->stok }} Pcs
                                        @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> 
                                                {{ $produk->stok }} Pcs
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('produk.show', $produk->id) }}" 
                                               class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl border border-slate-200/80 transition duration-150 active:scale-95 text-[11px]">
                                                Detail
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('produk.edit', $produk->id) }}" 
                                               class="px-3 py-1.5 bg-amber-400/20 hover:bg-amber-400/30 text-amber-900 font-bold rounded-xl border border-amber-400/30 transition duration-150 active:scale-95 text-[11px]">
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" id="delete-produk-form-{{ $produk->id }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('delete-produk-form-{{ $produk->id }}', 'Apakah Anda yakin ingin menghapus produk {{ $produk->nama }}?')" 
                                                        class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-700 font-bold rounded-xl border border-rose-500/20 transition duration-150 active:scale-95 text-[11px]">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-slate-400 py-12 text-xs">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div class="p-3 bg-slate-100 rounded-2xl border border-slate-200/80">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                            </div>
                                            <span class="font-bold text-slate-500 mt-1">Belum ada data produk.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($produks->hasPages())
                <div class="pt-2">
                    {{ $produks->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
<script>
    function dismissAlert(alertId) {
        let alertBox = document.getElementById(alertId);
        if (alertBox) {
            alertBox.style.transition = 'opacity 0.5s ease';
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            dismissAlert('success-alert');
        }, 4000);
    });
</script>
@endpush