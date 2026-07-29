<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    public function update(User $user, Penjualan $penjualan): bool
    {
        // strtolower digunakan agar 'ADMIN', 'Admin', maupun 'admin' tetap terbaca sama
        $roleName = strtolower($user->role->name ?? $user->role ?? '');
        return $roleName === 'admin' && $penjualan->status === 'OPEN';
    }

    public function delete(User $user, Penjualan $penjualan): bool
    {
        $roleName = strtolower($user->role->name ?? $user->role ?? '');
        return $roleName === 'admin' && $penjualan->status === 'OPEN';
    }
}