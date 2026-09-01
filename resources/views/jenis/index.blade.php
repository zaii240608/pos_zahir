@extends('layouts.app')

@section('title', 'Daftar Jenis Produk - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-100/70 py-8 text-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Session Alerts -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center gap-3 text-emerald-900 text-xs font-semibold shadow-xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="font-bold">Berhasil!</strong> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-center gap-3 text-rose-900 text-xs font-semibold shadow-xs">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <strong class="font-bold">Gagal:</strong> {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Clean Header Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl border border-teal-500/20 hidden sm:block shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kategori / Jenis Produk</h1>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Kelola jenis dan kelompok kategori untuk barang/produk kamu</p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('admin.jenis.create') }}" 
                       class="inline-flex items-center justify-center gap-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-sm hover:shadow transition-all duration-200 active:scale-95 border border-amber-300">
                        <svg class="w-4 h-4 text-slate-950 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Jenis</span>
                    </a>
                </div>
            </div>

            <!-- Tabel Data Jenis -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600 border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] uppercase font-black text-slate-500 tracking-wider">
                                <th scope="col" class="py-4 px-6 text-center w-16">No</th>
                                <th scope="col" class="py-4 px-6">Nama Jenis</th>
                                <th scope="col" class="py-4 px-6">Jumlah Produk</th>
                                <th scope="col" class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($jenisList as $index => $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-4 px-6 text-center font-bold text-slate-400">
                                        {{ method_exists($jenisList, 'firstItem') ? $jenisList->firstItem() + $index : $index + 1 }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-700 border border-teal-200/60 flex items-center justify-center font-bold text-xs shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <span class="font-bold text-slate-900 text-sm">{{ $item->nama_jenis }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                            <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                                            {{ $item->produks_count ?? ($item->produks ? $item->produks->count() : 0) }} Produk
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.jenis.edit', $item->id) }}" 
                                               class="px-3.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-900 font-extrabold rounded-lg border border-amber-200 transition shadow-2xs active:scale-95">
                                                <span>Edit</span>
                                            </a>

                                            <form action="{{ route('admin.jenis.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        onclick="confirmDelete('delete-form-{{ $item->id }}', 'Yakin ingin menghapus jenis ini?')" 
                                                        class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-extrabold rounded-lg border border-rose-200 transition shadow-2xs active:scale-95">
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-16 text-center text-slate-400">
                                        <div class="max-w-xs mx-auto">
                                            <div class="w-16 h-16 mx-auto mb-4 bg-slate-100 text-slate-300 rounded-2xl flex items-center justify-center border border-slate-200/60">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-bold text-slate-700">Belum ada data jenis produk</h4>
                                            <p class="text-xs text-slate-400 mt-1">Tambahkan kategori jenis produk baru untuk mengelompokkan barang kamu.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($jenisList, 'hasPages') && $jenisList->hasPages())
                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                        {{ $jenisList->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection