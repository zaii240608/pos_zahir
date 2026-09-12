@extends('layouts.app')

@section('title', 'Tambah Jenis Barang - Toko Kelontong Zahir')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6">

            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tambah Jenis Produk</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Buat kategori/jenis baru untuk mengelompokkan produk kamu</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-black uppercase tracking-wider text-slate-700">Form Jenis Baru</h2>
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                </div>

                <form action="{{ route('admin.jenis.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

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
                                   value="{{ old('nama_jenis') }}"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition duration-150 @error('nama_jenis') border-rose-400 bg-rose-50/30 @else border-slate-200/80 @enderror"
                                   placeholder="Contoh: Makanan, Minuman, Sembako..."
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

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.jenis.index') }}" 
                           class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition duration-150 active:scale-95">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-black text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl transition duration-150 shadow-xs border border-amber-300">
                            <span>Simpan Jenis</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection