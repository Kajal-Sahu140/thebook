<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class WarehouseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated as a warehouse
        if (!Auth::guard('warehouse')->check()) {
             return redirect()->route('warehouse.access.login')->with('error', 'Please log in to access the admin panel.');// Return 404 for unauthorized access
        }

        return $next($request); // Allow access
    }
}
