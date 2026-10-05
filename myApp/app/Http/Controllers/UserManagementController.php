<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Menampilkan seluruh pengguna.
     */
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah pengguna.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make(
                $request->validated('password')
            ),
            'role' => $request->validated('role'),
            'status' => $request->validated('status'),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(User $user)
    {
        return view(
            'admin.users.edit',
            compact('user')
        );
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ) {
        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'role' => $request->validated('role'),
            'status' => $request->validated('status'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make(
                $request->validated('password')
            );
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui.'
            );
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' =>
                    'Akun yang sedang login tidak dapat dihapus.',
            ]);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}