<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 'aktif',
        ])) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password salah atau akun tidak aktif.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            'pasien' => redirect()->route('pasien.dashboard'),
            default => $this->invalidRole($request),
        };
    }

    /**
     * Tangani role yang tidak valid.
     */
    private function invalidRole(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        abort(403, 'Role pengguna tidak valid.');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
