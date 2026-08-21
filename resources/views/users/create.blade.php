@extends('layouts.app')

@section('title', 'Tambah Pengguna - POS')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header & Tombol  -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-stone-200/80 shadow-sm">
                <div>
                    <h1 class="text-2xl font-extrabold text-stone-900 tracking-tight">Tambah Pengguna Baru</h1>
                    <p class="text-xs text-stone-500 mt-1">Buat akun pengguna baru untuk mengakses aplikasi POS</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-sm rounded-3xl border border-stone-200/80 p-6 sm:p-8">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <!-- Panggil Komponen Form -->
                    @include('users._form')

                    <!-- Tombol Action -->
                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-stone-100">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-5 py-2.5 bg-stone-100 text-stone-700 hover:bg-stone-200 text-xs font-extrabold rounded-2xl border border-stone-200 transition active:scale-95">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-extrabold rounded-2xl shadow-sm hover:shadow transition active:scale-95">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection