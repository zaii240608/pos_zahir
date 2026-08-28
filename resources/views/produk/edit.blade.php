@extends('layouts.app')

@section('title', 'Edit Produk - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Clean Header Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Produk</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Ubah informasi katalog produk <span class="font-bold text-slate-700">{{ $produk->nama }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-black uppercase tracking-wider text-slate-700">Form Perbarui Produk</h2>
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                </div>

                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Grid Nama Produk & Jenis Produk -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nama Produk -->
                        <div>
                            <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   id="nama" 
                                   value="{{ old('nama', $produk->nama) }}" 
                                   class="w-full px-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('nama') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
                                   placeholder="Masukkan nama produk..."
                                   required>
                            @error('nama')
                                <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Jenis Produk -->
                        <div>
                            <label for="jenis_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Jenis Produk <span class="text-rose-500">*</span>
                            </label>
                            <select name="jenis_id" 
                                    id="jenis_id" 
                                    required
                                    class="w-full px-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('jenis_id') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror">
                                <option value="">-- Pilih Jenis Produk --</option>
                                @foreach($jenislist as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_id', $produk->jenis_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Grid Harga Jual & Stok -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Harga Jual -->
                        <div>
                            <label for="harga_jual" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Harga Jual (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" 
                                   name="harga_jual" 
                                   id="harga_jual" 
                                   value="{{ old('harga_jual', $produk->harga_jual) }}" 
                                   min="0" 
                                   required 
                                   class="w-full px-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('harga_jual') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
                                   placeholder="0">
                            @error('harga_jual')
                                <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Stok Tersedia <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" 
                                   name="stok" 
                                   id="stok" 
                                   value="{{ old('stok', $produk->stok) }}" 
                                   min="0" 
                                   required 
                                   class="w-full px-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('stok') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
                                   placeholder="0">
                            @error('stok')
                                <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Deskripsi Produk <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <textarea name="deskripsi" 
                                  id="deskripsi" 
                                  rows="4" 
                                  class="w-full px-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('deskripsi') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror" 
                                  placeholder="Tulis deskripsi rinci mengenai produk...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Foto Produk -->
                    <div class="p-4 bg-slate-50/60 rounded-2xl border border-slate-200/80 space-y-3">
                        <label for="foto" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Foto Produk
                        </label>

                        @if($produk->foto)
                            <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-slate-200/80 w-fit shadow-2xs">
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-12 h-12 object-cover rounded-lg border border-slate-200/80">
                                <div class="pr-2">
                                    <p class="text-xs font-bold text-slate-700">Foto Saat Ini</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Akan diganti jika Anda mengunggah file baru</p>
                                </div>
                            </div>
                        @endif

                        <input type="file" 
                               name="foto" 
                               id="foto" 
                               accept="image/*" 
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-500/10 file:text-teal-700 hover:file:bg-teal-500/20 transition cursor-pointer">
                        @error('foto')
                            <p class="text-[11px] font-bold text-rose-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi Utama -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('produk.index') }}" 
                           class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition duration-150 active:scale-95">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl transition duration-150 shadow-xs border border-amber-300">
                            <span>Perbarui Produk</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection