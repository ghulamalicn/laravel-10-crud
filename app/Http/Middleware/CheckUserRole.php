<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->roles()->where('role_id', 1)->exists()) {
            return $next($request);
        }

        // If not role 1 and not already on the profile route, redirect
        if ($request->routeIs('profile')) {
            return $next($request);
        }

        return redirect()->route('profile');

    }
}
