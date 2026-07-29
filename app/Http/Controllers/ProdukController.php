<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\produk\StoreProdukRequest;
use App\Http\Requests\produk\UpdateProdukRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Produk::class);
        $produks = Produk::with('user')->latest()->paginate(10);
        return view('produk.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        // Mengambil data tervalidasi dari StoreProdukRequest (termasuk deskripsi)
        $validate = $request->validated();

        if ($request->hasFile('foto')) {
            $validate['foto'] = $request->file('foto')->store('produk_foto', 'public');
        }
        
        $validate['user_id'] = auth()->id();
        
        // Simpan produk
        Produk::create($validate);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);
        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        // Mengambil data tervalidasi dari UpdateProdukRequest
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

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        try {
            // Ambil path foto untuk dihapus nanti jika berhasil
            $fotoPath = $produk->foto;

            // Hapus data produk dari database terlebih dahulu
            $produk->delete();

            // Jika berhasil terhapus dari database, baru hapus file gambarnya di storage
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
        } catch (QueryException $e) {
            // Tangkap error jika produk terikat foreign key di item_penjualans (SQLSTATE 23000)
            if ($e->getCode() == 23000) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi/penjualan!');
            }

            return redirect()->route('produk.index')->with('error', 'Gagal menghapus produk!');
        }
    }
}