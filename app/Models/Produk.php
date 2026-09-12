<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    
    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'jenis_id',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemPenjualans()
    {
        return $this->hasMany(ItemPenjualan::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }
}
