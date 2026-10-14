<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Batasi akses berdasarkan role user.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $role = $user->roleData?->nama_role;

        if (!$role || !in_array($role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
