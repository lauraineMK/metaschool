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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect('login');
        }

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user's role matches the required one
        if ($user->role !== $role) {
            // Redirect to an error page or home page
            return redirect('home')->with('error', "You do not have access to this section.");
        }

        // If the role matches, proceed with the request
        return $next($request);
    }
}
