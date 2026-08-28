@extends('layouts.app')

@section('title', 'Detail Produk - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Clean Header Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Detail Produk</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Informasi lengkap mengenai <span class="font-bold text-slate-700">{{ $produk->nama_produk ?? $produk->nama }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('produk.edit', $produk->id) }}" 
                       class="inline-flex items-center justify-center gap-2 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs px-4 py-2.5 rounded-2xl transition-all duration-150 border border-amber-300 shadow-xs active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Produk</span>
                    </a>
                </div>
            </div>

            <!-- Detail Main Content Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-black uppercase tracking-wider text-slate-700">Ringkasan Spesifikasi</h2>
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                </div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                        
                        <!-- KOLOM KIRI: Gambar Produk + Navigasi Kembali -->
                        <div class="col-span-1 space-y-3">
                            @if($produk->foto)
                                <div class="relative group overflow-hidden rounded-2xl border border-slate-200/80 shadow-xs bg-slate-50">
                                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk ?? $produk->nama }}" class="w-full h-72 object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            @else
                                <div class="w-full h-72 bg-slate-50/80 rounded-2xl flex flex-col items-center justify-center text-slate-400 border border-dashed border-slate-300 gap-2">
                                    <div class="p-3 bg-slate-100 rounded-xl text-slate-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400">Tidak ada foto</span>
                                </div>
                            @endif

                            <a href="{{ route('produk.index') }}" 
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 active:scale-95 rounded-xl transition-all border border-slate-200/80 shadow-2xs">
                                Kembali
                            </a>
                        </div>

                        <!-- KOLOM KANAN: Informasi Detail -->
                        <div class="col-span-2 space-y-6">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Produk</span>
                                <h3 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">
                                    {{ $produk->nama_produk ?? $produk->nama }}
                                </h3>
                            </div>

                            <!-- Grid Info Harga, Stok, dan Jenis Produk -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Jenis Produk -->
                                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Jenis Produk</span>
                                    <div class="mt-2">
                                        @if($produk->jenis)
                                                {{ $produk->jenis->nama_jenis }}
                                        @else
                                            <span class="text-xs font-bold text-slate-400 italic">Belum diset</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Harga Jual -->
                                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Harga Jual</span>
                                    <p class="text-xl font-black mt-1">
                                        Rp {{ number_format($produk->harga_jual ?? $produk->harga ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Stok Tersedia -->
                                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Stok Tersedia</span>
                                    <div class="mt-2">
                                        @if(($produk->stok ?? 0) <= 5)
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span> {{ $produk->stok ?? 0 }} Pcs
                                        @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> {{ $produk->stok }} Pcs
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi & Pemilik -->
                            <div class="space-y-4">
                                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi Produk</span>
                                    <p class="text-xs font-medium text-slate-700 mt-1.5 whitespace-pre-line leading-relaxed">
                                        {{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                                    </p>
                                </div>

                                <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pemilik / Penginput</span>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <div class="w-7 h-7 rounded-full bg-teal-500/10 text-teal-700 border border-teal-500/20 flex items-center justify-center text-xs font-black">
                                                {{ strtoupper(substr($produk->user->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-bold text-slate-800">{{ $produk->user->name ?? 'Admin' }}</span>
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