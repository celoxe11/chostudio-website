<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string|array $roles): Response
    {
        // 1. Pastikan pengguna terotentikasi.
        if (!Auth::check()) {
            // Log::info('RoleMiddleware: User not authenticated');
            return redirect()->route('login')->with('warning', 'You must be logged in to access this page.');
        }

        $user = Auth::user();
        // Log::info('RoleMiddleware: User authenticated', ['user_id' => $user->id, 'username' => $user->username, 'role' => $user->role ?? 'NO ROLE']);

        // Pastikan role ada pada objek user    
        if (!isset($user->role)) {
            // Log::error('RoleMiddleware: User has no role', ['user_id' => $user->id]);
            return abort(403, 'Your account is missing a defined role.');
        }

        // Ambil peran yang disyaratkan dari route dan konversi ke lowercase
        $requiredRoles = is_array($roles) ? $roles : explode(',', $roles);
        $requiredRoles = array_map('strtolower', $requiredRoles);

        // Ambil peran pengguna saat ini dan konversi ke lowercase
        $userRole = strtolower($user->role);

        // Log::info('RoleMiddleware: Checking roles', [
        //     'user_role' => $userRole,
        //     'required_roles' => $requiredRoles
        // ]);

        // 2. Periksa apakah peran pengguna (lowercase) termasuk dalam peran yang disyaratkan (lowercase).
        if (! in_array($userRole, $requiredRoles)) {
            // Log::warning('RoleMiddleware: Role mismatch', [
            //     'user_role' => $userRole,
            //     'required_roles' => $requiredRoles
            // ]);
            // Abort the request with a 403 Forbidden status if the role doesn't match
            return abort(403, 'Unauthorized. You do not have the required role to access this resource.');
        }

        // Log::info('RoleMiddleware: Role check passed, proceeding');
        // 3. Role cocok, lanjutkan permintaan.
        return $next($request);
    }
}
