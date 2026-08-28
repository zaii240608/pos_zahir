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
        $qty = $request->input('qty') ?? $request->input('kuantitas') ?? 1;

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'penjualan_id' => 'nullable|exists:penjualans,id',
        ]);

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

        // Cek stok produk di keranjang vs stok DB
        $itemExisting = ItemPenjualan::where('penjualan_id', $penjualan->id)
            ->where('produk_id', $produk->id)
            ->first();

        $currentQtyInCart = $itemExisting ? $itemExisting->kuantitas : 0;
        $totalRequestedQty = $currentQtyInCart + $qty;

        if ($produk->stok < $totalRequestedQty) {
            return back()->with('error', "Stok produk tidak mencukupi! Tersisa {$produk->stok}.");
        }

        $harga = $produk->harga_jual ?? $produk->harga ?? $produk->harga_satuan ?? 0;

        if ($itemExisting) {
            $itemExisting->update([
                'kuantitas' => $totalRequestedQty,
                'subtotal'  => $totalRequestedQty * $harga,
            ]);
        } else {
            ItemPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id'    => $produk->id,
                'kuantitas'    => $qty,
                'harga_satuan' => $harga,
                'subtotal'     => $qty * $harga,
            ]);
        }

        $this->updateTotalPenjualan($penjualan);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Memperbarui kuantitas item di keranjang (+ / -) via AJAX / Normal
    public function update(Request $request, $id)
    {
        try {
            $item = ItemPenjualan::findOrFail($id);
            $penjualan = $item->penjualan;
            $action = $request->input('action');

            if ($action === 'decrement') {
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
                // Cek Stok Produk
                if ($item->produk && $item->produk->stok <= $item->kuantitas) {
                    throw new \Exception("Stok produk telah mencapai batas maksimum ({$item->produk->stok})!");
                }

                $newQty = $item->kuantitas + 1;
                $item->update([
                    'kuantitas' => $newQty,
                    'subtotal'  => $newQty * $item->harga_satuan,
                ]);
            }

            $this->updateTotalPenjualan($penjualan);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kuantitas berhasil diperbarui.'
                ]);
            }

            return back();

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    // Menghapus item dari keranjang via AJAX / Normal
    public function destroy(Request $request, $id)
    {
        try {
            $item = ItemPenjualan::findOrFail($id);

            $this->authorize('delete', $item); 

            $penjualan = $item->penjualan;
            $item->delete();

            if ($penjualan) {
                $this->updateTotalPenjualan($penjualan);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang.'
                ]);
            }

            return back()->with('success', 'Item berhasil dihapus dari keranjang.');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    // Helper private untuk kalkulasi total harga
    private function updateTotalPenjualan(Penjualan $penjualan)
    {
        $total = $penjualan->items()->sum('subtotal');
        $penjualan->update(['total_harga' => $total]);
    }
}