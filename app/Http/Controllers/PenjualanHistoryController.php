<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use Carbon\Carbon;

class PenjualanHistoryController extends Controller
{
    // Menampilkan daftar rekap per Bulan
    public function index()
    {
        $historyBulanan = Penjualan::selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, SUM(total_pembayaran) as total_omzet, COUNT(*) as total_transaksi')
            ->where('status', 'COMPLETED')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('admin.history.index', compact('historyBulanan'));
    }

    // Menampilkan rekap penjualan per Minggu beserta detail hariannya
    public function showWeek()
    {
        // 1. Rekap data mingguan (hanya transaksi COMPLETED)
        $historyMingguanRaw = Penjualan::selectRaw('
                YEAR(created_at) as tahun,
                WEEK(created_at, 3) as minggu_ke,
                SUM(total_pembayaran) as total_omzet,
                COUNT(*) as total_transaksi
            ')
            ->where('status', 'COMPLETED')
            ->groupByRaw('YEAR(created_at), WEEK(created_at, 3)')
            ->orderBy('tahun', 'desc')
            ->orderBy('minggu_ke', 'desc')
            ->get();

        // 2. Format label minggu, hitung rentang tanggal (Senin - Minggu), dan query detail harian
        $historyMingguan = $historyMingguanRaw->map(function ($item) {
            $date = Carbon::now()->setISODate($item->tahun, $item->minggu_ke);
            $start = $date->copy()->startOfWeek(); // Senin 00:00:00
            $end = $date->copy()->endOfWeek();     // Minggu 23:59:59

            $item->label_minggu = 'Minggu Ke-' . $item->minggu_ke;
            $item->rentang_tanggal = $start->translatedFormat('d M') . ' - ' . $end->translatedFormat('d M Y');

            // Fetch detail harian untuk rentang minggu ini
            $item->detail_harian = Penjualan::selectRaw('
                    DATE(created_at) as tanggal,
                    SUM(total_pembayaran) as total_omzet,
                    COUNT(*) as total_transaksi
                ')
                ->where('status', 'COMPLETED')
                ->whereBetween('created_at', [$start->toDateTimeString(), $end->toDateTimeString()])
                ->groupByRaw('DATE(created_at)')
                ->orderBy('tanggal', 'asc')
                ->get();

            return $item;
        });

        return view('admin.history.week', compact('historyMingguan'));
    }

    // Menampilkan daftar hari di bulan tertentu
    public function showMonth($tahun, $bulan)
    {
        // 1. Data Rekap Harian untuk Grid
        $historyHarian = Penjualan::selectRaw('DATE(created_at) as tanggal, SUM(total_pembayaran) as total_omzet, COUNT(*) as total_transaksi')
            ->where('status', 'COMPLETED')
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        // 2. Data Summary Rekap Bulan untuk Card Informasi
        $totalOmzet = $historyHarian->sum('total_omzet');
        $totalTransaksi = $historyHarian->sum('total_transaksi');
        
        $totalProdukTerjual = ItemPenjualan::whereHas('penjualan', function($q) use ($tahun, $bulan) {
            $q->where('status', 'COMPLETED')
              ->whereYear('created_at', $tahun)
              ->whereMonth('created_at', $bulan);
        })->sum('kuantitas'); // Menggunakan kolom 'kuantitas' sesuai tabel ItemPenjualan

        $rekapBulan = (object) [
            'total_omzet' => $totalOmzet,
            'total_transaksi' => $totalTransaksi,
            'total_produk_terjual' => $totalProdukTerjual,
        ];

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        return view('admin.history.month', compact('historyHarian', 'rekapBulan', 'namaBulan', 'tahun', 'bulan'));
    }

    // Menampilkan detail seluruh transaksi pada tanggal tertentu
    public function showDateDetail($tanggal)
    {
        $transaksis = Penjualan::with('items.produk')
            ->where('status', 'COMPLETED')
            ->whereDate('created_at', $tanggal)
            ->latest()
            ->get();

        return view('admin.history.detail', compact('transaksis', 'tanggal'));
    }
}