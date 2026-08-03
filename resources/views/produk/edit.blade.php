@extends('layouts.app')

@section('title', 'Edit Produk - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Tombol Kembali -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Edit Produk</h1>
                    <p class="text-xs text-stone-500 mt-1">Ubah informasi katalog produk {{ $produk->nama }}</p>
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

            <!-- Form Card -->
            <div class="bg-white shadow-sm rounded-3xl border border-stone-200/80 p-6 sm:p-8">
                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Grid Nama Produk & Jenis Produk -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nama Produk -->
                        <div>
                            <label for="nama" class="block text-xs font-extrabold uppercase tracking-wider text-stone-700 mb-2">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required 
                                   class="w-full rounded-2xl border-stone-200 shadow-sm focus:border-teal-600 focus:ring-teal-600 text-sm border px-4 py-3 text-stone-900 placeholder-stone-400 transition">
                            @error('nama')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Produk -->
                        <div>
                            <label for="jenis_id" class="block text-xs font-extrabold uppercase tracking-wider text-stone-700 mb-2">
                                Jenis Produk <span class="text-rose-500">*</span>
                            </label>
                            <select name="jenis_id" id="jenis_id" required
                                    class="w-full rounded-2xl border-stone-200 shadow-sm focus:border-teal-600 focus:ring-teal-600 text-sm border px-4 py-3 text-stone-900 transition">
                                <option value="">-- Pilih Jenis Produk --</option>
                                @foreach($jenislist as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_id', $produk->jenis_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Grid Harga Jual & Stok -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Harga Jual -->
                        <div>
                            <label for="harga_jual" class="block text-xs font-extrabold uppercase tracking-wider text-stone-700 mb-2">
                                Harga Jual (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" min="0" required 
                                   class="w-full rounded-2xl border-stone-200 shadow-sm focus:border-teal-600 focus:ring-teal-600 text-sm border px-4 py-3 text-stone-900 transition">
                            @error('harga_jual')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-xs font-extrabold uppercase tracking-wider text-stone-700 mb-2">
                                Stok Tersedia <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" min="0" required 
                                   class="w-full rounded-2xl border-stone-200 shadow-sm focus:border-teal-600 focus:ring-teal-600 text-sm border px-4 py-3 text-stone-900 transition">
                            @error('stok')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label for="deskripsi" class="block text-xs font-extrabold uppercase tracking-wider text-stone-700 mb-2">
                            Deskripsi Produk <span class="text-stone-400 font-normal lowercase">(opsional)</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" 
                                  class="w-full rounded-2xl border-stone-200 shadow-sm focus:border-teal-600 focus:ring-teal-600 text-sm border px-4 py-3 text-stone-900 placeholder-stone-400 transition" 
                                  placeholder="Tulis deskripsi rinci mengenai produk...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Produk -->
                    <div>
                        <label for="foto" class="block text-xs font-extrabold uppercase tracking-wider text-stone-700 mb-1">
                            Foto Produk
                        </label>
                        <p class="text-xs text-stone-500 mb-3">Biarkan kosong jika tidak ingin mengganti foto yang sudah ada.</p>
                        
                        @if($produk->foto)
                            <div class="mb-4 flex items-center gap-3 bg-stone-50 p-3 rounded-2xl border border-stone-200/80 w-fit">
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" class="w-14 h-14 object-cover rounded-xl border border-stone-200 shadow-sm">
                                <span class="text-xs text-stone-600 font-bold">Foto saat ini</span>
                            </div>
                        @endif

                        <input type="file" name="foto" id="foto" accept="image/*" 
                               class="block w-full text-sm text-stone-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-teal-50 file:text-teal-800 hover:file:bg-teal-100 transition cursor-pointer">
                        @error('foto')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-stone-100">
                        <a href="{{ route('produk.index') }}" 
                           class="px-5 py-2.5 bg-stone-100 text-stone-700 hover:bg-stone-200 text-xs font-extrabold rounded-2xl border border-stone-200 transition active:scale-95">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-extrabold rounded-2xl shadow-sm hover:shadow transition active:scale-95">
                            Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection