<?php

namespace App\Services;

use App\Models\Produk;

class MonitoringStokService
{
    /**
     * Mengambil daftar produk dengan stok rendah (1 - 5).
     */
    public function produkStokRendah(int $batas = 5, int $perPage = 5)
    {
        return Produk::where('stok', '>', 0)
            ->where('stok', '<=', $batas)
            ->orderBy('stok', 'asc')
            ->paginate($perPage, ['*'], 'stok_rendah_page');
    }

}