<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // If $roles is a string (e.g., 'artist'), convert it to an array
        $roles = is_array($roles) ? $roles : explode(',', $roles);

        // 1. Check if the user is authenticated.
        if (!Auth::check()) {
            // If not logged in, redirect them to the login page with a warning.
            // Using 'login' as the named route for your login page.
            return redirect()->route('login')->with('warning', 'You must be logged in to access this page.');
        }

        $user = Auth::user();
        
        // Ensure the user model has a 'role' attribute (based on your seeder, it should be present in the 'members' table mapped to Auth)
        if (!isset($user->role)) {
            // Abort if the user object is missing the role field
            return abort(403, 'Your account is missing a defined role.');
        }

        // 2. Check if the authenticated user's role is in the list of allowed roles.
        if (! in_array($user->role, $roles)) {
            // Abort the request with a 403 Forbidden status if the role doesn't match
            return abort(403, 'Unauthorized. You do not have the required role to access this resource.');
        }

        // 3. If the role matches, allow the request to proceed.
        return $next($request);
    }
}
