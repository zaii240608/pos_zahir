<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemPenjualanController extends Controller
{
    // Menyimpan produk ke keranjang (POS & Edit Transaksi)
    public function store(Request $request)
    {
        // 1. Dapatkan nilai kuantitas (dukung name="qty" atau name="kuantitas")
        $qty = $request->input('qty') ?? $request->input('kuantitas') ?? 1;

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'penjualan_id' => 'nullable|exists:penjualans,id',
        ]);

        // 2. Jika ada penjualan_id dari Form Edit, pakai itu. Jika tidak, cari/buat transaksi OPEN milik user
        if ($request->filled('penjualan_id')) {
            $penjualan = Penjualan::findOrFail($request->penjualan_id);
        } else {
            $penjualan = Penjualan::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'status' => 'OPEN'
                ],
                [
                    'total_harga' => 0,
                    'total_pembayaran' => 0,
                    'metode_pembayaran' => '-'
                ]
            );
        }

        $produk = Produk::findOrFail($request->produk_id);

        // 3. Cek stok produk
        if ($produk->stok < $qty) {
            return back()->with('error', 'Stok produk tidak mencukupi!');
        }

        // 4. Deteksi otomatis nama kolom harga ($produk->harga_jual / harga / harga_satuan)
        $harga = $produk->harga_jual ?? $produk->harga ?? $produk->harga_satuan ?? 0;

        // 5. Cek apakah item sudah ada di keranjang transaksi ini
        $item = ItemPenjualan::where('penjualan_id', $penjualan->id)
            ->where('produk_id', $produk->id)
            ->first();

        if ($item) {
            // Jika sudah ada, tambahkan kuantitasnya
            $newQty = $item->kuantitas + $qty;
            $item->update([
                'kuantitas' => $newQty,
                'subtotal'  => $newQty * $harga,
            ]);
        } else {
            // Jika belum, buat item baru
            ItemPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id'    => $produk->id,
                'kuantitas'    => $qty,
                'harga_satuan' => $harga,
                'subtotal'     => $qty * $harga,
            ]);
        }

        // Update total harga pada tabel penjualan
        $this->updateTotalPenjualan($penjualan);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Menghapus item dari keranjang
    public function destroy($id)
    {
        $item = ItemPenjualan::findOrFail($id);

        $this->authorize('delete', $item); 

        $penjualan = $item->penjualan;
        $item->delete();

        // Update ulang total harga
        if ($penjualan) {
            $this->updateTotalPenjualan($penjualan);
        }

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    // Helper private untuk kalkulasi total harga
    private function updateTotalPenjualan(Penjualan $penjualan)
    {
        // Panggil ulang relasi items agar fresh dari database
        $total = $penjualan->items()->sum('subtotal');
        
        $penjualan->update(['total_harga' => $total]);
    }

    /**
     * Memperbarui kuantitas item di keranjang (+ / - / ubah angka)
     */
    public function update(Request $request, $id)
    {
        $item = ItemPenjualan::findOrFail($id);
        $penjualan = $item->penjualan;

        $action = $request->input('action'); // 'increment' atau 'decrement'

        if ($action === 'decrement') {
            // Jika Qty tinggal 1 lalu diklik minus, langsung hapus item dari keranjang
            if ($item->kuantitas <= 1) {
                $item->delete();
            } else {
                $newQty = $item->kuantitas - 1;
                $item->update([
                    'kuantitas' => $newQty,
                    'subtotal'  => $newQty * $item->harga_satuan,
                ]);
            }
        } elseif ($action === 'increment') {
            // Cek stok produk terlebih dahulu
            if ($item->produk && $item->produk->stok <= $item->kuantitas) {
                return back()->with('error', 'Stok produk sudah mencapai batas maksimum!');
            }

            $newQty = $item->kuantitas + 1;
            $item->update([
                'kuantitas' => $newQty,
                'subtotal'  => $newQty * $item->harga_satuan,
            ]);
        }

        // Hitung ulang total harga penjualan
        $this->updateTotalPenjualan($penjualan);

        return back();
    }
}