@extends('layouts.app')

@section('title', 'Tambah Pengguna - Toko Kelontong Zahir')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-0.5">
                            <span>Manajemen Pengguna</span>
                            <span>•</span>
                            <span class="text-slate-400">Pendaftaran Baru</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Tambah Pengguna Baru</h1>
                    </div>
                </div>

                <div class="hidden sm:flex items-center justify-center w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/60 shrink-0">
                    <svg class="w-6 h-6 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white shadow-xs rounded-3xl border border-slate-200/80 p-6 sm:p-8">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @include('users._form')

                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-2xl border border-slate-200 transition-all duration-150 active:scale-95">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-black rounded-2xl shadow-md shadow-amber-500/20 hover:shadow-lg transition-all duration-150 active:scale-95 border border-amber-300">
                            <span>Simpan Pengguna</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection