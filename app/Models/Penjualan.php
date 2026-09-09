<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ItemPenjualan::class, 'penjualan_id');
    }

    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'bayar',
        'kembalian',
        'metode_pembayaran',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemPenjualans()
    {
        return $this->hasMany(ItemPenjualan::class);
    }
}
