<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (
            $request->header('X-API-KEY') !== 'KUNCI_AYAM_123' &&
            $request->query('api_key') !== 'KUNCI_AYAM_123'
        ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
