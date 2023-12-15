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

           // Check if the user is not logged in
            if (!$user) {
                 // Check if the current route is neither the login nor register route to avoid a loop
                if ($request->routeIs(['login', 'register'])) {
                    // return redirect()->route('login'); // Redirect to the login screen
                    return $next($request);
                }
            }elseif($user){
                 // Check if the current route is neither the login nor register route to avoid a loop
                 if ($request->routeIs(['logout'])) {
                    // return redirect()->route('login'); // Redirect to the login screen
                    return $next($request);
                }
            }

           // Check if the user has role 1
           if ($user && $user->roles()->where('role_id', 1)->exists()) {
               return $next($request);
           }

           // If not role 1 and not already on the profile route, redirect to profile
           if ($user && !$request->routeIs('profile')) {
               return redirect()->route('profile');
           }

           // If already on the profile route or not logged in, allow access
           return $next($request);

    }
}
