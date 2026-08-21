@extends('layouts.app')

@section('title', 'Edit Jenis & List Produk - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Grid Layout 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- KOLOM KIRI: Form Edit Jenis -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden sticky top-6">
                        
                        <!-- Card Header Teal -->
                        <div class="px-6 py-5 bg-[#0d5c58] text-white flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 text-amber-300 flex items-center justify-center font-bold border border-white/10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold">Edit Jenis Produk</h2>
                                <p class="text-xs text-emerald-100/70">Perbarui nama kategori ini</p>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <form action="{{ route('admin.jenis.update', $jenis->id) }}" method="POST" class="p-6 space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-1.5 h-4 bg-[#0d5c58] rounded-full inline-block"></span>
                                    <label for="nama_jenis" class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Nama Jenis / Kategori <span class="text-rose-500">*</span>
                                    </label>
                                </div>

                                <input type="text" 
                                       name="nama_jenis" 
                                       id="nama_jenis" 
                                       value="{{ old('nama_jenis', $jenis->nama_jenis) }}"
                                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('nama_jenis') border-rose-500 ring-1 ring-rose-500 @else border-slate-200 focus:border-[#0d5c58] focus:ring-1 focus:ring-[#0d5c58] @enderror rounded-xl focus:outline-none focus:bg-white transition-all font-medium text-slate-800 placeholder-slate-400"
                                       placeholder="Contoh: Makanan, Minuman..."
                                       required 
                                       autofocus>

                                @error('nama_jenis')
                                    <p class="flex items-center gap-1 text-xs text-rose-500 mt-1.5 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Meta Info Waktu -->
                            <div class="p-3.5 rounded-xl bg-emerald-50/50 border border-emerald-100/60 grid grid-cols-2 gap-3 text-[11px] text-slate-600">
                                <div>
                                    <span class="block font-semibold text-emerald-800/60 uppercase tracking-wider text-[9px]">Dibuat Pada</span>
                                    <span class="font-bold text-slate-700">
                                        {{ $jenis->created_at ? $jenis->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block font-semibold text-emerald-800/60 uppercase tracking-wider text-[9px]">Terakhir Diubah</span>
                                    <span class="font-bold text-slate-700">
                                        {{ $jenis->updated_at ? $jenis->updated_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.jenis.index') }}" 
                                   class="px-4 py-2.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition-all">
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KOLOM KANAN: Daftar Produk yang Menggunakan Jenis Ini -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        
                        <!-- Header Daftar Produk -->
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-4 bg-[#0d5c58] rounded-full inline-block"></span>
                                <h3 class="text-sm font-bold text-slate-800">Daftar Produk Menggunakan Jenis Ini</h3>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-bold text-[#0d5c58] bg-emerald-100/70 rounded-lg">
                                {{ $jenis->produks ? $jenis->produks->count() : 0 }} Produk
                            </span>
                        </div>

                        <!-- List / Table Produk -->
                        <div class="p-4">
                            @php
                                $produks = $jenis->produks ?? collect();
                            @endphp

                            @if($produks->isEmpty())
                                <!-- State Kosong -->
                                <div class="text-center py-10 px-4">
                                    <div class="w-12 h-12 mx-auto mb-3 text-slate-300 bg-slate-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-500">Belum Ada Produk</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada produk yang saat ini terhubung dengan jenis "{{ $jenis->nama_jenis }}".</p>
                                </div>
                            @else
                                <!-- List Item Produk -->
                                <div class="divide-y divide-slate-100">
                                    @foreach($produks as $produk)
                                        <div class="py-3 flex items-center justify-between hover:bg-slate-50/80 px-2 rounded-xl transition-colors">
                                            <div class="flex items-center gap-3">
                                                <!-- Foto Produk -->
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200/80 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                                    @if(isset($produk->foto) && $produk->foto)
                                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    @endif
                                                </div>

                                                <!-- Teks Nama Produk & Harga (Sebelumnya terpotong) -->
                                                <div>
                                                    <h4 class="text-xs font-bold text-slate-800">
                                                        {{ $produk->nama_produk ?? $produk->nama ?? 'Nama Produk Tidak Ditemukan' }}
                                                    </h4>
                                                    <p class="text-[11px] font-medium text-slate-400">
                                                        Rp {{ number_format($produk->harga ?? $produk->harga_jual ?? 0, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Indikator Stok -->
                                            <div class="text-right">
                                                <span class="inline-block text-[11px] font-semibold px-2 py-0.5 rounded-md {{ ($produk->stok ?? 0) > 0 ? 'bg-slate-100 text-slate-600' : 'bg-rose-100 text-rose-600' }}">
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