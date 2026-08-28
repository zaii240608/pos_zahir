<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\users\StoreUserRequest;
use App\Http\Requests\users\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('search')) {
            $search = $request->search;
            
            // Optimasi: Gabung nama & email dalam 1 query condition (jauh lebih cepat)
            $query->whereRaw("CONCAT(name, ' ', email) LIKE ?", ["%{$search}%"]);
        }

        $users = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('users.partials.table', compact('users'))->render();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // 1. Cegah menghapus akun yang sedang login saat ini
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
        } catch (QueryException $e) {
            // 2. Kode 23000 = Integrity constraint violation (Foreign Key constraint di database)
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('warning', "Pengguna '{$user->name}' tidak dapat dihapus karena memiliki riwayat transaksi penjualan yang tercatat dalam sistem.");
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mencoba menghapus pengguna.');
        }
    }
}