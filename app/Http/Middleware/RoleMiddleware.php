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
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string  $role
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function handle(Request $request, Closure $next, string $role): Response
   {
       // Check if the user is authenticated
       if (!Auth::check()) {
           return redirect('/login'); // Redirect to login page if user is not authenticated
       }


       $user = Auth::user();


       // Check if the user has the required role
       if ($user->role !== $role) {
           return redirect('/')->with('error', 'Unauthorized access to this section.');
       }


       return $next($request);
   }
}


