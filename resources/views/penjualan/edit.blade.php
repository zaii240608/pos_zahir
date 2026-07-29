@extends('layouts.app')
@section('title', 'Edit Transaction #'.$penjualan->id)

@section('content')
@include('layouts.navbar')

<div class="min-h-screen bg-stone-100/70 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Notifikasi Pesan -->
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-teal-50 border border-teal-200 text-teal-800 px-5 py-4 rounded-2xl shadow-sm">
                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl shadow-sm">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 text-[10px] font-black uppercase bg-teal-100 text-teal-900 rounded-full border border-teal-200">
                        EDIT MODE
                    </span>
                    <h2 class="text-xl font-extrabold text-stone-900">
                        Edit Transaksi<span class="text-amber-600">#{{ $penjualan->id }}</span>
                    </h2>
                </div>
                <p class="text-xs text-stone-500 mt-1">Perbarui item di keranjang atau selesaikan pembayaran untuk transaksi ini.</p>
            </div>
            
            <a href="{{ route('penjualan.index') }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold rounded-2xl border border-stone-200 transition active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- KIRI: DAFTAR SEMUA PRODUK UNTUK DIPILIH (7 COLUMNS) -->
            <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-stone-100">
                        <h3 class="font-extrabold text-stone-900 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Pilih Produk
                        </h3>
                        <span class="text-[11px] font-semibold text-stone-400">Klik (+) untuk menambahkan ke keranjang</span>
                    </div>

                    <!-- Form Pencarian Produk -->
                    <div class="mb-4 relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search-produk" placeholder="Search product name..." 
                            class="w-full bg-stone-50 border border-stone-200 rounded-2xl pl-10 pr-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 text-stone-800 placeholder-stone-400 transition">
                    </div>

                    <!-- List Grid Produk (Scrollable) -->
                    <div class="space-y-2.5 max-h-[500px] overflow-y-auto pr-1" id="product-list">
                        @forelse($produks as $produk)
                            <div class="product-item flex items-center justify-between bg-stone-50 hover:bg-teal-50/50 border border-stone-200/80 hover:border-teal-200 rounded-2xl p-3.5 transition duration-150 group">
                                <div class="space-y-0.5">
                                    <p class="product-name font-bold text-stone-900 text-xs group-hover:text-teal-800 transition">
                                        {{ $produk->nama ?? $produk->nama_produk }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs font-black text-teal-700">
                                            Rp {{ number_format($produk->harga ?? $produk->harga_satuan ?? $produk->harga_jual ?? 0, 0, ',', '.') }}
                                        </p>
                                        <span class="text-[10px] text-stone-300">|</span>
                                        <span class="text-[10px] font-bold text-stone-600 bg-white px-2 py-0.5 rounded-full border border-stone-200">
                                            Stock: {{ $produk->stok }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Form Tambah Produk ke Keranjang -->
                                <form action="{{ route('detail-penjualan.store') }}" method="POST" class="flex items-center gap-1.5 shrink-0">
                                    @csrf
                                    <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    <input type="number" name="kuantitas" value="1" min="1" max="{{ $produk->stok }}" 
                                           class="w-12 bg-white border border-stone-200 rounded-xl text-center text-xs font-bold p-1.5 text-stone-800 focus:outline-none focus:border-teal-600">
                                    <button type="submit" 
                                            class="w-8 h-8 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-xl flex items-center justify-center text-sm shadow-sm transition active:scale-95" 
                                            title="Add to Cart">
                                        +
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center text-stone-400 py-10 text-xs">
                                Tidak ada produk yang tersedia saat ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- KANAN: RINGKASAN KERANJANG & AKSI (5 COLUMNS) -->
            <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-stone-100">
                        <h3 class="font-extrabold text-stone-900 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Keranjang Belanja
                        </h3>
                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 bg-amber-100 text-amber-900 rounded-full border border-amber-200">
                            {{ $penjualan->items->count() }} Items
                        </span>
                    </div>

                    <!-- DAFTAR PRODUK DALAM KERANJANG -->
                    <div class="mb-4">
                        <div class="overflow-x-auto max-h-[280px] overflow-y-auto pr-1">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-stone-50 border-b border-stone-200/80 text-stone-500">
                                        <th class="py-2.5 px-2 font-extrabold text-[10px] uppercase">Barang</th>
                                        <th class="py-2.5 px-1 font-extrabold text-[10px] uppercase text-center">Kuantitas</th>
                                        <th class="py-2.5 px-2 font-extrabold text-[10px] uppercase text-right">Subtotal</th>
                                        <th class="py-2.5 px-1 font-extrabold text-[10px] uppercase text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100">
                                    @forelse($penjualan->items as $item)
                                        <tr class="hover:bg-stone-50 transition-colors">
                                            <td class="py-2.5 px-2">
                                                <p class="font-bold text-stone-800 text-xs">
                                                    {{ $item->produk->nama ?? $item->produk->nama_produk ?? 'Product' }}
                                                </p>
                                                <p class="text-[10px] text-stone-400">
                                                    @ Rp{{ number_format($item->harga_satuan ?? $item->harga ?? ($item->subtotal / ($item->kuantitas ?? $item->jumlah ?? 1)), 0, ',', '.') }}
                                                </p>
                                            </td>

                                            <!-- TOMBOL MINUS (-), ANGKA QTY, DAN PLUS (+) -->
                                            <td class="py-2.5 px-1 text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <!-- Tombol Kurang (-) -->
                                                    <form action="{{ route('detail-penjualan.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" name="action" value="decrement" 
                                                                class="w-5 h-5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold rounded-lg flex items-center justify-center text-[11px] transition active:scale-90">
                                                            -
                                                        </button>
                                                    </form>

                                                    <!-- Angka Qty -->
                                                    <span class="px-1.5 py-0.5 bg-stone-50 font-black text-stone-800 text-xs border border-stone-200 rounded-md min-w-[20px] text-center">
                                                        {{ $item->kuantitas ?? $item->jumlah }}
                                                    </span>

                                                    <!-- Tombol Tambah (+) -->
                                                    <form action="{{ route('detail-penjualan.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" name="action" value="increment" 
                                                                class="w-5 h-5 bg-stone-100 hover:bg-teal-700 hover:text-white text-stone-700 font-bold rounded-lg flex items-center justify-center text-[11px] transition active:scale-90">
                                                            +
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                            <td class="py-2.5 px-2 text-right font-extrabold text-teal-900 text-xs whitespace-nowrap">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                            
                                            <!-- OTORISASI HAPUS ITEM -->
                                            <td class="py-2.5 px-1 text-center">
                                                @can('delete', $item)
                                                <form action="{{ route('detail-penjualan.destroy', $item->id) }}" method="POST" id="delete-item-form-{{ $item->id }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            onclick="confirmDelete('delete-item-form-{{ $item->id }}', 'Are you sure you want to remove this item from cart?')" 
                                                            class="text-rose-500 hover:text-rose-700 p-1 rounded-lg hover:bg-rose-50 transition"
                                                            title="Delete Item">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @else
                                                    <span class="text-stone-300 text-xs">-</span>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-stone-400 text-xs">
                                                Keranjang Anda kosong.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN BAWAH: TOTAL, METODE PEMBAYARAN & TOMBOL -->
                <div class="pt-4 border-t border-stone-100 space-y-4">
                    <!-- Display Total Harga -->
                    <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200/80 flex items-center justify-between">
                        <span class="text-xs font-extrabold text-stone-500 uppercase tracking-wider">Total</span>
                        <p class="text-2xl font-black text-teal-900 tracking-tight">
                            Rp {{ number_format($penjualan->items->sum('subtotal'), 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- FORM AKSI PENJUALAN -->
                    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')

                        <!-- Dropdown Metode Pembayaran -->
                        <div>
                            <label class="block text-[11px] font-extrabold text-stone-600 uppercase tracking-wider mb-1">
                                Metode Pembayaran
                            </label>
                            <select name="metode_pembayaran" required 
                                    class="w-full bg-white border border-stone-200 rounded-xl p-2.5 text-xs font-bold text-stone-800 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 shadow-sm">
                                <option value="CASH" {{ $penjualan->metode_pembayaran == 'CASH' ? 'selected' : '' }}>CASH</option>
                                <option value="QRIS" {{ $penjualan->metode_pembayaran == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                <option value="TRANSFER" {{ $penjualan->metode_pembayaran == 'TRANSFER' ? 'selected' : '' }}>BANK TRANSFER</option>
                            </select>
                        </div>

                        <!-- TOMBOL AKSI UTAMA -->
                        <div class="space-y-2">
                            <button type="submit" name="action" value="checkout" 
                                    class="w-full bg-teal-700 hover:bg-teal-800 text-white font-extrabold py-3 rounded-2xl text-xs shadow-md transition active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Bayar / Beli</span>
                            </button>

                            <button type="submit" name="action" value="save" 
                                    class="w-full bg-stone-900 hover:bg-black text-amber-400 font-extrabold py-2.5 rounded-2xl text-xs shadow-sm transition active:scale-95">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <!-- TOMBOL BATALKAN TRANSAKSI -->
                    @can('delete', $penjualan)
                    <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" id="cancel-penjualan-form-{{ $penjualan->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                onclick="confirmDelete('cancel-penjualan-form-{{ $penjualan->id }}', 'Are you sure you want to cancel this transaction?')" 
                                class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold py-2 rounded-2xl text-xs transition active:scale-95">
                            Batalkan Transaksi
                        </button>
                    </form>
                    @endcan
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Live Search Script -->
<script>
    document.getElementById('search-produk').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll('.product-item');

        items.forEach(function(item) {
            let name = item.querySelector('.product-name').textContent.toLowerCase();
            if (name.includes(filter)) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>
@endsection