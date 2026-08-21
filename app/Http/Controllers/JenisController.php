<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class JenisController extends Controller
{
    public function index()
    {
        $jenisList = Jenis::withCount('produks')->latest()->paginate(10);
        return view('jenis.index', compact('jenisList'));
    }

    public function create()
    {
        return view('jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis,nama_jenis',
        ], [
            'nama_jenis.required' => 'Nama jenis wajib diisi.',
            'nama_jenis.unique'   => 'Nama jenis produk ini sudah ada.',
        ]);

        Jenis::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('admin.jenis.index')->with('success', 'Jenis produk berhasil ditambahkan!');
    }

    public function edit(Jenis $jeni)
    {
        $jeni->load('produks');
        return view('jenis.edit', ['jenis' => $jeni]);
    }

    public function update(Request $request, Jenis $jeni)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis,nama_jenis,' . $jeni->id,
        ], [
            'nama_jenis.required' => 'Nama jenis wajib diisi.',
            'nama_jenis.unique'   => 'Nama jenis produk ini sudah ada.',
        ]);

        $jeni->update([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('admin.jenis.index')->with('success', 'Jenis produk berhasil diperbarui!');
    }

    public function destroy(Jenis $jeni)
    {
        try {
            $jeni->delete();
            return redirect()->route('admin.jenis.index')->with('success', 'Jenis produk berhasil dihapus!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('admin.jenis.index')->with('error', 'Jenis tidak dapat dihapus karena masih digunakan oleh beberapa produk!');
            }

            return redirect()->route('admin.jenis.index')->with('error', 'Gagal menghapus jenis produk!');
        }
    }
}