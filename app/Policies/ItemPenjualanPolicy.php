<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    /**
     * Menentukan apakah user bisa melihat detail item penjualan.
     */
    public function view(User $user, ItemPenjualan $itemPenjualan): bool
    {
        return true; // Admin & Kasir dapat melihat
    }

    /**
     * Menentukan apakah user bisa menghapus item dari keranjang.
     */
    public function delete(User $user, ItemPenjualan $itemPenjualan): bool
    {
        return true;
    }
}