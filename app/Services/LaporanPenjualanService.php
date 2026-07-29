<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanPenjualanService
{
    /**
     * Mengambil ringkasan data penjualan untuk hari ini.
     */
    public function ringkasanHariIni(): array
    {
        // Hanya hitung transaksi yang statusnya COMPLETED hari ini
        $data = DB::table('penjualans')
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'COMPLETED') 
            ->selectRaw("
                COUNT(*) as total_transaksi,
                SUM(COALESCE(total_pembayaran, 0)) as total_penjualan,
                SUM(CASE WHEN LOWER(metode_pembayaran) = 'cash' THEN COALESCE(total_pembayaran, 0) ELSE 0 END) as total_cash,
                SUM(CASE WHEN LOWER(metode_pembayaran) != 'cash' THEN COALESCE(total_pembayaran, 0) ELSE 0 END) as total_non_tunai
            ")
            ->first();

        return [
            'total_transaksi' => $data->total_transaksi ?? 0,
            'total_penjualan' => $data->total_penjualan ?? 0,
            'total_cash'      => $data->total_cash ?? 0,
            'total_non_tunai' => $data->total_non_tunai ?? 0,
        ];
    }

    /**
     * Mengambil daftar produk terlaris hari ini.
     */
    public function produkTerlarisHariIni(int $limit = 5)
    {
        // Hanya hitung item dari transaksi yang statusnya COMPLETED
        return DB::table('item_penjualans')
            ->join('penjualans', 'item_penjualans.penjualan_id', '=', 'penjualans.id')
            ->join('produks', 'item_penjualans.produk_id', '=', 'produks.id')
            ->whereDate('penjualans.created_at', Carbon::today())
            ->where('penjualans.status', 'COMPLETED')
            ->select(
                'produks.id',
                'produks.nama',
                'produks.foto',
                'produks.stok',
                DB::raw('SUM(item_penjualans.kuantitas) as total_terjual')
            )
            ->groupBy('produks.id', 'produks.nama', 'produks.foto', 'produks.stok')
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }
}