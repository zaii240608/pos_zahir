<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()
            ->when($user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }

    public function create()
    {
        $user = Auth::user();

        $penjualan = Penjualan::with('items.produk')
            ->where('user_id', $user->id)
            ->where('status', 'OPEN')
            ->first();

        $produks = Produk::all();

        return view('penjualan.create', compact('penjualan', 'produks'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $itemsInput = is_string($request->input('items')) 
            ? json_decode($request->input('items'), true) 
            : $request->input('items');

        if (empty($itemsInput) || !is_array($itemsInput)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $statusInput = strtoupper($request->input('status', 'COMPLETED'));
        $isCompleted = ($statusInput === 'COMPLETED');

        try {
            DB::transaction(function () use ($request, $user, $itemsInput, $isCompleted, $statusInput) {
                
                $penjualan = Penjualan::create([
                    'user_id'           => $user->id,
                    'total_harga'       => 0,
                    'total_pembayaran'  => 0,
                    'metode_pembayaran' => $request->input('metode_pembayaran', 'CASH'),
                    'status'            => $statusInput,
                ]);

                $totalHarga = 0;

                foreach ($itemsInput as $item) {
                    $produk = Produk::where('id', $item['id'])->lockForUpdate()->firstOrFail();
                    
                    $qty = (int) $item['qty'];
                    if ($qty <= 0) continue;

                    // Potong stok HANYA jika transaksi diselesaikan
                    if ($isCompleted) {
                        if ($produk->stok < $qty) {
                            throw new \Exception("Stok produk '{$produk->nama}' tidak mencukupi (Tersisa: {$produk->stok})!");
                        }
                        $produk->decrement('stok', $qty);
                    }

                    $hargaSatuan = $produk->harga_jual ?? $produk->harga ?? 0;
                    $subtotal = $hargaSatuan * $qty;
                    $totalHarga += $subtotal;

                    $penjualan->items()->create([
                        'produk_id'    => $produk->id,
                        'kuantitas'    => $qty,
                        'harga_satuan' => $hargaSatuan,
                        'subtotal'     => $subtotal,
                    ]);
                }

                $bayar = null;
                $kembalian = null;
                if ($isCompleted && strtoupper($request->input('metode_pembayaran', 'CASH')) === 'CASH') {
                    $bayar = (int) $request->input('uang_dibayar', 0);
                    if ($bayar < $totalHarga) {
                        throw new \Exception('Uang dibayar harus sama atau lebih besar dari total transaksi.');
                    }
                    $kembalian = $bayar - $totalHarga;
                }

                $penjualan->update([
                    'total_harga'      => $totalHarga,
                    'total_pembayaran' => $isCompleted ? $totalHarga : 0,
                    'bayar'            => $bayar,
                    'kembalian'        => $kembalian,
                ]);
            });

            $pesan = $isCompleted 
                ? 'Transaksi berhasil diselesaikan!' 
                : 'Draft transaksi berhasil disimpan.';

            return redirect()->route('penjualan.index')->with('success', $pesan);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with('items.produk')->findOrFail($id);

        $this->authorize('update', $penjualan);

        if ($penjualan->status !== 'OPEN') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah selesai tidak dapat diedit.');
        }

        $produks = Produk::all();

        return view('penjualan.edit', compact('penjualan', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::with('items.produk')->findOrFail($id);

        if ($penjualan->status !== 'OPEN') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Transaksi ini sudah selesai dan tidak dapat diubah.');
        }

        $itemsInput = is_string($request->input('items')) 
            ? json_decode($request->input('items'), true) 
            : $request->input('items');

        if (empty($itemsInput) || !is_array($itemsInput)) {
            return back()->with('error', 'Keranjang tidak boleh kosong!');
        }

        $isCheckout = ($request->input('action') === 'checkout');

        try {
            DB::transaction(function () use ($request, $penjualan, $itemsInput, $isCheckout) {
                
                // 1. Hapus item lama untuk diganti item terbaru
                $penjualan->items()->delete();

                $totalHarga = 0;

                // 2. Simpan item-item baru
                foreach ($itemsInput as $item) {
                    $produk = Produk::where('id', $item['id'])->lockForUpdate()->firstOrFail();
                    $qty = (int) $item['qty'];

                    if ($qty <= 0) continue;

                    // Potong stok hanya jika diselesaikan (Checkout)
                    if ($isCheckout) {
                        if ($produk->stok < $qty) {
                            throw new \Exception("Stok produk '{$produk->nama}' tidak mencukupi (Tersisa: {$produk->stok})!");
                        }
                        $produk->decrement('stok', $qty);
                    }

                    $hargaSatuan = $produk->harga_jual ?? $produk->harga ?? 0;
                    $subtotal = $hargaSatuan * $qty;
                    $totalHarga += $subtotal;

                    $penjualan->items()->create([
                        'produk_id'    => $produk->id,
                        'kuantitas'    => $qty,
                        'harga_satuan' => $hargaSatuan,
                        'subtotal'     => $subtotal,
                    ]);
                }

                $bayar = null;
                $kembalian = null;
                $metodePembayaran = strtoupper($request->input('metode_pembayaran', 'CASH'));
                if ($isCheckout && $metodePembayaran === 'CASH' && $request->filled('uang_dibayar')) {
                    $bayar = (int) $request->input('uang_dibayar');
                    if ($bayar < $totalHarga) {
                        throw new \Exception('Uang dibayar harus sama atau lebih besar dari total transaksi.');
                    }
                    $kembalian = $bayar - $totalHarga;
                }

                // 3. Update data transaksi utama
                $penjualan->update([
                    'total_harga'       => $totalHarga,
                    'total_pembayaran'  => $isCheckout ? $totalHarga : 0,
                    'metode_pembayaran' => $request->input('metode_pembayaran', 'CASH'),
                    'status'            => $isCheckout ? 'COMPLETED' : 'OPEN',
                    'bayar'             => $bayar,
                    'kembalian'         => $kembalian,
                ]);
            });

            $pesan = $isCheckout 
                ? 'Transaksi berhasil diselesaikan!' 
                : 'Perubahan draft transaksi berhasil disimpan.';

            return redirect()->route('penjualan.index')->with('success', $pesan);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('items.produk', 'user')->findOrFail($id);

        return view('penjualan.detail', compact('penjualan'));
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::with('items.produk')->findOrFail($id);

        $this->authorize('delete', $penjualan);

        DB::transaction(function () use ($penjualan) {
            // KEMBALIKAN STOK HANYA JIKA STATUS TRANSAKSI SUDAH COMPLETED
            if ($penjualan->status === 'COMPLETED') {
                foreach ($penjualan->items as $item) {
                    if ($item->produk) {
                        $item->produk->increment('stok', $item->kuantitas);
                    }
                }
            }

            // Jika status masih OPEN, langsung hapus (karena stok DB belum pernah dipotong)
            $penjualan->items()->delete();
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dibatalkan/dihapus.');
    }
}