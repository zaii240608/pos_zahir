<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['role_id', 'name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Kunci ID Role agar tidak berubah-ubah di seluruh aplikasi
    public const ROLE_ADMIN = 1;
    public const ROLE_KASIR = 2;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ================= HELPER METHODS ================= */

    /**
     * Cek apakah user memiliki role Admin
     */
    public function isAdmin(): bool
    {
        return (int) $this->role_id === self::ROLE_ADMIN;
    }

    /**
     * Cek apakah user memiliki role Kasir
     */
    public function isKasir(): bool
    {
        return (int) $this->role_id === self::ROLE_KASIR;
    }

    /* ================= RELATIONSHIPS ================= */

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}