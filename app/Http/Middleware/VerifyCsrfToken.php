<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post') && !$this->isCsrfTokenValid($request)) {
            return response()->json(['message' => 'CSRF token mismatch.'], 403);
        }

        return $next($request);
    }

    /**
     * Check the validity of the CSRF token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isCsrfTokenValid(Request $request)
    {
        return $request->session()->token() === $request->input('_token');
    }
}
