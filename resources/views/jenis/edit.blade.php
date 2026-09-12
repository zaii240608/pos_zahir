@extends('layouts.app')

@section('title', 'Edit Jenis Barang - Toko Kelontong Zahir')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-6">

            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Jenis Produk</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Perbarui nama kategori dan lihat daftar produk terkait</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden lg:sticky lg:top-6">
                        
                        <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                            <h2 class="text-xs font-black uppercase tracking-wider text-slate-700">Form Update Jenis</h2>
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        </div>

                        <form action="{{ route('admin.jenis.update', $jenis->id) }}" method="POST" class="p-6 space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="nama_jenis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Nama Jenis / Kategori <span class="text-rose-500">*</span>
                                </label>

                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="nama_jenis" 
                                           id="nama_jenis" 
                                           value="{{ old('nama_jenis', $jenis->nama_jenis) }}"
                                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('nama_jenis') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
                                           placeholder="Contoh: Makanan, Minuman..."
                                           required 
                                           autofocus>
                                </div>

                                @error('nama_jenis')
                                    <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/60 grid grid-cols-2 gap-3 text-[11px] text-slate-600">
                                <div>
                                    <span class="block font-bold text-slate-400 uppercase tracking-wider text-[9px]">Dibuat Pada</span>
                                    <span class="font-bold text-slate-700">
                                        {{ $jenis->created_at ? $jenis->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-400 uppercase tracking-wider text-[9px]">Terakhir Diubah</span>
                                    <span class="font-bold text-slate-700">
                                        {{ $jenis->updated_at ? $jenis->updated_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.jenis.index') }}" 
                                   class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition duration-150 active:scale-95">
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl transition duration-150 shadow-xs border border-amber-300">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                        
                        <div class="px-6 py-4 border-b border-slate-200/80 bg-slate-50/80 flex items-center justify-between">
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-700">Produk Terkait</h3>
                            <span class="px-3 py-1 text-[11px] font-bold text-teal-800 bg-teal-50 border border-teal-200/80 rounded-full">
                                {{ $jenis->produks ? $jenis->produks->count() : 0 }} Produk
                            </span>
                        </div>

                        <div class="p-4">
                            @php
                                $produks = $jenis->produks ?? collect();
                            @endphp

                            @if($produks->isEmpty())
                                <div class="text-center py-12 px-4">
                                    <div class="w-14 h-14 mx-auto mb-3 text-slate-300 bg-slate-100 rounded-2xl flex items-center justify-center border border-slate-200/60">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-xs font-bold text-slate-700">Belum Ada Produk</h4>
                                    <p class="text-[11px] text-slate-400 mt-0.5 max-w-xs mx-auto">Tidak ada produk yang saat ini terhubung dengan jenis "{{ $jenis->nama_jenis }}".</p>
                                </div>
                            @else
                                <div class="divide-y divide-slate-100">
                                    @foreach($produks as $produk)
                                        <div class="py-3 flex items-center justify-between hover:bg-slate-50 px-3 rounded-2xl transition duration-150">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200/80 overflow-hidden shrink-0 flex items-center justify-center">
                                                    @if(isset($produk->foto) && $produk->foto)
                                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    @endif
                                                </div>

                                                <div>
                                                    <h4 class="text-xs font-bold text-slate-900">
                                                        {{ $produk->nama_produk ?? $produk->nama ?? 'Nama Produk Tidak Ditemukan' }}
                                                    </h4>
                                                    <p class="text-[11px] font-bold text-teal-700 mt-0.5">
                                                        Rp {{ number_format($produk->harga ?? $produk->harga_jual ?? 0, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <span class="inline-block text-[11px] font-bold px-2.5 py-1 rounded-full {{ ($produk->stok ?? 0) > 0 ? 'bg-slate-100 text-slate-700 border border-slate-200/80' : 'bg-rose-50 text-rose-700 border border-rose-200/80' }}">
                                                    Stok: {{ $produk->stok ?? 0 }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>  
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection