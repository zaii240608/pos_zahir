@extends('layouts.app')

@section('title', 'Tambah Jenis Produk - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6">
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm overflow-hidden">
                
                <div class="px-6 py-5 bg-teal-700 text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 text-amber-300 flex items-center justify-center font-bold border border-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold">Tambah Jenis Produk</h2>
                        <p class="text-xs text-teal-100/80">Buat kategori/jenis baru untuk mengelompokkan produk kamu</p>
                    </div>
                </div>

                <form action="{{ route('admin.jenis.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-1.5 h-4 bg-amber-500 rounded-full inline-block"></span>
                            <label for="nama_jenis" class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nama Jenis / Kategori <span class="text-rose-500">*</span>
                            </label>
                        </div>

                        <input type="text" 
                               name="nama_jenis" 
                               id="nama_jenis" 
                               value="{{ old('nama_jenis') }}"
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('nama_jenis') border-rose-500 ring-1 ring-rose-500 @else border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 @enderror rounded-xl focus:outline-none focus:bg-white transition-all font-medium text-slate-800 placeholder-slate-400"
                               placeholder="Contoh: Makanan, Minuman, Sembako..."
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

                    <!-- Tombol Aksi Utama: Amber Button -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.jenis.index') }}" 
                           class="px-4 py-2.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition-all">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl transition-all shadow-sm">
                            Simpan Jenis
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection