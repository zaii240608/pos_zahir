@extends('layouts.app')

@section('title', 'Tambah Barang - Toko Kelontong Zahir')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Clean Header Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tambah Produk Baru</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Masukkan informasi produk baru ke dalam katalog sistem</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-xs rounded-3xl border border-slate-200/80 p-6 sm:p-8">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Nama Produk -->
                    <div>
                        <label for="nama" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required 
                               placeholder="Masukkan nama produk..."
                               class="w-full rounded-2xl border-slate-200 shadow-2xs focus:border-teal-500 focus:ring-teal-500 text-xs font-medium border px-4 py-3 text-slate-900 placeholder-slate-400 transition-all">
                        @error('nama')
                            <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Produk -->
                    <div>
                        <label for="jenis_id" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                            Jenis Produk <span class="text-rose-500">*</span>
                        </label>
                        <select name="jenis_id" id="jenis_id" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-medium text-slate-800 shadow-2xs focus:ring-teal-500 focus:border-teal-500 transition-all">
                            <option value="">-- Pilih Jenis Produk --</option>
                            @foreach($jenislist as $jenis)
                                <option value="{{ $jenis->id }}" {{ old('jenis_id') == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_id')
                            <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid Harga Beli, Harga Jual & Stok -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Harga Beli -->
                        <div>
                            <label for="harga_beli" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Harga Beli (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="harga_beli" id="harga_beli" value="{{ old('harga_beli') }}" min="0" required
                                   placeholder="0"
                                   class="w-full rounded-2xl border-slate-200 shadow-2xs focus:border-teal-500 focus:ring-teal-500 text-xs font-medium border px-4 py-3 text-slate-900 transition-all">
                            @error('harga_beli')
                                <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label for="harga_jual" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Harga Jual (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" min="0" required 
                                   placeholder="0"
                                   class="w-full rounded-2xl border-slate-200 shadow-2xs focus:border-teal-500 focus:ring-teal-500 text-xs font-medium border px-4 py-3 text-slate-900 transition-all">
                            @error('harga_jual')
                                <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Stok Awal <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok') }}" min="0" required 
                                   placeholder="0"
                                   class="w-full rounded-2xl border-slate-200 shadow-2xs focus:border-teal-500 focus:ring-teal-500 text-xs font-medium border px-4 py-3 text-slate-900 transition-all">
                            @error('stok')
                                <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label for="deskripsi" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                            Deskripsi Produk <span class="text-slate-400 font-normal normal-case">(opsional)</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" 
                                  class="w-full rounded-2xl border-slate-200 shadow-2xs focus:border-teal-500 focus:ring-teal-500 text-xs font-medium border px-4 py-3 text-slate-900 placeholder-slate-400 transition-all" 
                                  placeholder="Tulis deskripsi rinci mengenai produk...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Produk -->
                    <div>
                        <label for="foto" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                            Foto Produk <span class="text-slate-400 font-normal normal-case">(opsional)</span>
                        </label>
                        <input type="file" name="foto" id="foto" accept="image/*" 
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-500/10 file:text-teal-700 hover:file:bg-teal-500/20 transition cursor-pointer">
                        @error('foto')
                            <p class="text-rose-600 text-xs mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100">
                        <a href="{{ route('produk.index') }}" 
                           class="px-5 py-2.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold rounded-2xl border border-slate-200/80 transition active:scale-95">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl transition duration-150 shadow-xs border border-amber-300">
                            <span>Simpan Produk</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection