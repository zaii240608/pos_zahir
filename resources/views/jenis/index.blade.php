@extends('layouts.app')

@section('title', 'Daftar Jenis Produk - POS')

@section('content')

    @include('layouts.navbar')

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl text-xs font-semibold flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-semibold flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        {{ session('error') }}
                    </span>
                </div>
            @endif

            <!-- Header Halaman -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-teal-100 shadow-sm">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-amber-500 rounded-full inline-block"></span>
                        Kategori / Jenis Produk
                    </h1>
                    <p class="text-xs text-slate-500 mt-1 pl-4">Kelola jenis dan kelompok kategori untuk barang/produk kamu.</p>
                </div>

                <!-- Tombol Tambah dengan Aksen Amber -->
                <a href="{{ route('admin.jenis.create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-900 rounded-xl text-xs font-bold transition-all shadow-sm active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Jenis
                </a>
            </div>

            <!-- Tabel Data Jenis -->
            <div class="bg-white rounded-2xl border border-teal-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-teal-50/70 border-b border-teal-100 text-[11px] font-bold text-teal-900 uppercase tracking-wider">
                                <th class="py-3.5 px-6">No</th>
                                <th class="py-3.5 px-6">Nama Jenis</th>
                                <th class="py-3.5 px-6">Jumlah Produk</th>
                                <th class="py-3.5 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                            @forelse($jenisList as $index => $item)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6 text-slate-400 font-bold">
                                        {{ $jenisList->firstItem() + $index }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-black text-slate-800">{{ $item->nama_jenis }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center py-1 text-teal-700 font-bold text-[11px]">
                                            {{ $item->produks_count ?? $item->produks->count() }} Produk
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.jenis.edit', $item->id) }}" 
                                            class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl border border-slate-200/80 transition shadow-xs active:scale-95 text-xs">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.jenis.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis ini?')" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-4 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-xl border border-rose-200 transition shadow-xs active:scale-95 text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        Belum ada data jenis produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($jenisList, 'hasPages') && $jenisList->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $jenisList->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection