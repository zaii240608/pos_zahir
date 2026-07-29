<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPenjualan extends Model   
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'kuantitas',
        'harga_satuan',
        'subtotal',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}