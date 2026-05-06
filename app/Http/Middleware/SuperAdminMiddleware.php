<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || $admin->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang bisa mengakses halaman ini');
        }

        return $next($request);
    }
}
