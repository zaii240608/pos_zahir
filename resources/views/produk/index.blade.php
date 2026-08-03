@extends('layouts.app')

@section('title', 'Daftar Produk - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Notifikasi Pesan -->
            @if(session('success'))
                <div id="success-alert" class="mb-6 flex items-center justify-between gap-3 bg-teal-50 border border-teal-200 text-teal-800 px-5 py-4 rounded-2xl shadow-sm transition-opacity duration-500">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="dismissAlert('success-alert')" class="text-teal-600 hover:text-teal-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Header Halaman & Tombol Tambah Produk -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Daftar Produk POS</h1>
                    <p class="text-xs text-stone-500 mt-1">Kelola katalog produk, stok, dan harga penjualan toko Anda.</p>
                </div>
                
                <div>
                    <a href="{{ route('produk.create') }}" 
                       class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-extrabold px-5 py-2.5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 text-sm active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Produk</span>
                    </a>
                </div>
            </div>

            <!-- Tabel Daftar Produk -->
            <div class="bg-white shadow-sm rounded-3xl border border-stone-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-stone-50 border-b border-stone-200/80 text-stone-700">
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">#</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Foto</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Nama Produk</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Jenis Produk</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Harga Jual</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider">Stok</th>
                                <th class="p-4 font-extrabold text-xs uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($produks as $index => $produk)
                                <tr class="hover:bg-stone-50/80 transition-colors">
                                    <td class="p-4 text-stone-800 font-bold">
                                        {{ $produks->firstItem() + $index }}
                                    </td>
                                    <td class="p-4">
                                        @if($produk->foto)
                                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-11 h-11 object-cover rounded-xl border border-stone-200 shadow-sm">
                                        @else
                                            <div class="w-11 h-11 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-400 text-[10px] font-bold text-center leading-tight">
                                                Foto
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-stone-800 font-bold">
                                        {{ $produk->nama }}
                                    </td>
                                    <td class="p-4">
                                        @if($produk->jenis)
                                            <span class="inline-flex items-center py-1 border-teal-200/60 text-teal-800 font-extrabold text-xs">
                                                {{ $produk->jenis->nama_jenis }}
                                            </span>
                                        @elseif($produk->nama_jenis)
                                            <span class="inline-flex items-center py-1 border-teal-200/60 text-teal-800 font-extrabold text-xs">
                                                {{ \App\Models\Jenis::find($produk->nama_jenis)?->nama_jenis ?? '-' }}
                                            </span>
                                        @else
                                            <span class="text-stone-400 italic text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-teal-900 font-black whitespace-nowrap">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        @if($produk->stok <= 5)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold text-rose-700">
                                                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span> 
                                                {{ $produk->stok }} Pcs (Menipis)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-extrabold text-stone-800">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 
                                                {{ $produk->stok }} Pcs
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('produk.show', $produk->id) }}" 
                                               class="px-4 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 font-bold rounded-full border border-stone-300/50 transition shadow-xs active:scale-95 text-xs">
                                                Detail
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('produk.edit', $produk->id) }}" 
                                               class="px-4 py-1.5 bg-amber-100/70 hover:bg-amber-200 text-amber-900 font-bold rounded-full border border-amber-300/50 transition shadow-xs active:scale-95 text-xs">
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" id="delete-produk-form-{{ $produk->id }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('delete-produk-form-{{ $produk->id }}', 'Apakah Anda yakin ingin menghapus produk {{ $produk->nama }}?')" 
                                                        class="px-4 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-full border border-rose-200 transition shadow-xs active:scale-95 text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-stone-400 py-12 text-sm">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-10 h-10 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <span>Belum ada data produk.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $produks->links() }}
            </div>

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