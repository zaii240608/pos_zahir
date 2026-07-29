<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Tentukan apakah user berhak melakukan request ini.
     */
    public function authorize(): bool
    {
        return true; // Ubah ke true agar tidak kena 403 Forbidden
    }

    /**
     * Aturan validasi saat TAMBAH user baru.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ];
    }

    /**
     * Pesan error kustom (Opsional).
     */
    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role_id.required'  => 'Role wajib dipilih.',
            'role_id.exists'    => 'Role tidak valid.',
        ];
    }
}