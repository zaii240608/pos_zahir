<?php

namespace App\Http\Controllers;

use App\Services\LaporanPenjualanService;
use App\Services\MonitoringStokService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    protected $laporanPenjualanService;
    protected $monitoringStokService;

    public function __construct(
        LaporanPenjualanService $laporanPenjualanService,
        MonitoringStokService $monitoringStokService
    ) {
        $this->laporanPenjualanService = $laporanPenjualanService;
        $this->monitoringStokService = $monitoringStokService;
    }

    public function index()
    {
        $tanggalHariIni = Carbon::now(); 
        $produkTerlaris = $this->laporanPenjualanService->produkTerlarisHariIni();
        $ringkasan = $this->laporanPenjualanService->ringkasanHariIni();
        $produkStokRendah = $this->monitoringStokService->produkStokRendah();

        return view('dashboard', compact(
            'tanggalHariIni', 
            'ringkasan', 
            'produkStokRendah', 
            'produkTerlaris'
        ));
    }
}