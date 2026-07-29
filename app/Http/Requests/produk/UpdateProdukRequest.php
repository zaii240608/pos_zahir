<?php

namespace App\Http\Requests\produk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ];
    }
}   