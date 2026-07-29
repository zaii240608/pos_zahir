@extends('layouts.app')

@section('title', 'Detail Produk - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Tombol Kembali -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Detail Produk</h1>
                    <p class="text-xs text-stone-500 mt-1">Informasi lengkap mengenai produk {{ $produk->nama }}</p>
                </div>
                
                <div>
                    <a href="{{ route('produk.index') }}" 
                       class="inline-flex items-center gap-2 bg-stone-100 hover:bg-stone-200 text-stone-700 font-extrabold px-5 py-2.5 rounded-2xl border border-stone-200 shadow-sm transition-all duration-200 text-sm active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            <!-- Card Detail Produk -->
            <div class="bg-white shadow-sm rounded-3xl border border-stone-200/80 p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                    
                    <!-- Gambar Produk -->
                    <div class="col-span-1 flex justify-center">
                        @if($produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-full h-72 object-cover rounded-2xl border border-stone-200 shadow-sm">
                        @else
                            <div class="w-full h-72 bg-stone-100 rounded-2xl flex flex-col items-center justify-center text-stone-400 border border-stone-200 gap-2">
                                <svg class="w-12 h-12 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-bold text-stone-400">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Detail -->
                    <div class="col-span-2 space-y-6">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-stone-400">Nama Produk</span>
                            <h2 class="text-2xl font-black text-stone-900 mt-0.5 tracking-tight">{{ $produk->nama }}</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200/70">
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-stone-400">Harga Jual</span>
                                <p class="text-xl font-black text-teal-900 mt-1">
                                    Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200/70">
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-stone-400">Stok Tersedia</span>
                                <div class="mt-1">
                                    @if($produk->stok <= 5)
                                        <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-rose-100 text-rose-900 border border-rose-200 inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span> {{ $produk->stok }} Pcs (Habis)
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-100 text-emerald-900 border border-emerald-200 inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> {{ $produk->stok }} Pcs
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200/70">
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-stone-400">Deskripsi Produk</span>
                                <p class="text-sm font-medium text-stone-700 mt-1.5 whitespace-pre-line leading-relaxed">
                                    {{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                                </p>
                            </div>

                            <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200/70 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-stone-400">Pemilik / Penginput</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="w-6 h-6 rounded-full bg-teal-100 text-teal-900 flex items-center justify-center text-[10px] font-black">
                                            {{ strtoupper(substr($produk->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-extrabold text-stone-800">{{ $produk->user->name ?? 'Admin' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi Edit & Delete -->
                        <div class="pt-4 flex items-center gap-3 border-t border-stone-100">
                            @can('update', $produk)
                                <a href="{{ route('produk.edit', $produk->id) }}" 
                                   class="bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-extrabold px-5 py-2.5 rounded-xl border border-amber-200 transition active:scale-95 shadow-sm">
                                    Edit Produk
                                </a>
                            @endcan
                            
                            @can('delete', $produk)
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" id="delete-produk-form-{{ $produk->id }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete('delete-produk-form-{{ $produk->id }}', 'Apakah Anda yakin ingin menghapus produk {{ $produk->nama }}?')" 
                                            class="bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-800 border border-rose-200 text-xs font-extrabold px-5 py-2.5 rounded-xl transition active:scale-95 shadow-sm">
                                        Hapus Produk
                                    </button>
                                </form>
                            @endcan
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection