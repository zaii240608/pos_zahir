@extends('layouts.app')

@section('title', 'Detail Produk - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Card Utama -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                
                <!-- Card Header Teal -->
                <div class="px-6 py-5 bg-[#0d5c58] text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 text-amber-300 flex items-center justify-center font-bold border border-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold">Detail Produk</h2>
                        <p class="text-xs text-emerald-100/70">Informasi lengkap mengenai produk {{ $produk->nama_produk ?? $produk->nama }}</p>
                    </div>
                </div>

                <!-- Detail Body -->
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        
                        <!-- KOLOM KIRI: Gambar Produk + Tombol Tepat Di Bawahnya -->
                        <div class="col-span-1">
                            @if($produk->foto)
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk ?? $produk->nama }}" class="w-full h-72 object-cover rounded-2xl border border-slate-200 shadow-sm">
                            @else
                                <div class="w-full h-72 bg-slate-50 rounded-2xl flex flex-col items-center justify-center text-slate-400 border border-slate-200/80 gap-2">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-slate-400">Tidak ada foto</span>
                                </div>
                            @endif

                            <!-- TOMBOL KEMBALI PAS DI BAWAH GAMBAR -->
                            <a href="{{ route('produk.index') }}" 
                               class="mt-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 active:scale-95 rounded-xl transition-all border border-slate-200/60 shadow-sm">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>

                        <!-- KOLOM KANAN: Informasi Detail -->
                        <div class="col-span-2 space-y-6">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Nama Produk</span>
                                <h3 class="text-2xl font-black text-slate-800 mt-0.5 tracking-tight">
                                    {{ $produk->nama_produk ?? $produk->nama }}
                                </h3>
                            </div>

                            <!-- Grid Info Harga, Stok, dan Jenis Produk -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Jenis Produk -->
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Jenis Produk</span>
                                    <div class="mt-2">
                                        @if($produk->jenis)
                                            <span class="inline-flex items-center px-3 py-1 rounded-xl bg-emerald-100/70 border border-emerald-200 text-[#0d5c58] font-bold text-xs">
                                                {{ $produk->jenis->nama_jenis }}
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-slate-400 italic">Belum diset</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Harga Jual -->
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Harga Jual</span>
                                    <p class="text-xl font-black text-[#0d5c58] mt-1">
                                        Rp {{ number_format($produk->harga_jual ?? $produk->harga ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Stok Tersedia -->
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Stok Tersedia</span>
                                    <div class="mt-2">
                                        @if(($produk->stok ?? 0) <= 5)
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-rose-100 text-rose-800 border border-rose-200 inline-flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span> {{ $produk->stok ?? 0 }} Pcs
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> {{ $produk->stok }} Pcs
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi & Pemilik -->
                            <div class="space-y-4">
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Deskripsi Produk</span>
                                    <p class="text-sm font-medium text-slate-700 mt-1.5 whitespace-pre-line leading-relaxed">
                                        {{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                                    </p>
                                </div>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Pemilik / Penginput</span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="w-6 h-6 rounded-full bg-[#0d5c58]/10 text-[#0d5c58] flex items-center justify-center text-[10px] font-black">
                                                {{ strtoupper(substr($produk->user->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-extrabold text-slate-800">{{ $produk->user->name ?? 'Admin' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection