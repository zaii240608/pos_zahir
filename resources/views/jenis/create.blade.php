@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-stone-800">Tambah Jenis Produk</h1>
        <p class="text-xs text-stone-500 mt-1">Buat kategori/jenis baru untuk mengelompokkan produk kamu.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
        <form action="{{ route('admin.jenis.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <label for="nama_jenis" class="text-xs font-bold text-stone-700">Nama Jenis / Kategori</label>
                <input type="text" 
                       name="nama_jenis" 
                       id="nama_jenis" 
                       value="{{ old('nama_jenis') }}"
                       placeholder="Contoh: Makanan, Minuman, Pakaian, dll." 
                       class="w-full px-4 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs font-medium text-stone-800 focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all outline-none"
                       required>
                @error('nama_jenis')
                    <p class="text-[11px] text-red-500 font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-stone-100">
                <a href="{{ route('admin.jenis.index') }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold text-stone-600 bg-stone-100 hover:bg-stone-200 transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 rounded-xl text-xs font-bold text-teal-950 bg-amber-400 hover:bg-amber-500 shadow-sm transition-all">
                    Simpan Jenis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection