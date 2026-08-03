<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Produk;
use App\Http\Requests\produk\StoreProdukRequest;
use App\Http\Requests\produk\UpdateProdukRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Produk::class);
        $produks = Produk::with(['user', 'jenis'])->latest()->paginate(10);
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $this->authorize('create', Produk::class);
        $jenislist = Jenis::all();
        return view('produk.create', compact('jenislist'));
    }

    public function store(StoreProdukRequest $request)
    {
        $validate = $request->validated();

        if ($request->hasFile('foto')) {
            $validate['foto'] = $request->file('foto')->store('produk_foto', 'public');
        }
        
        $validate['user_id'] = auth()->id();
        
        Produk::create($validate);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);
        $jenislist = Jenis::all();
        return view('produk.edit', compact('produk', 'jenislist'));
    }

    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $validate = $request->validated();

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $validate['foto'] = $request->file('foto')->store('produk_foto', 'public');
        }

        $produk->update($validate);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        try {
            $fotoPath = $produk->foto;

            $produk->delete();

            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi/penjualan!');
            }

            return redirect()->route('produk.index')->with('error', 'Gagal menghapus produk!');
        }
    }
}