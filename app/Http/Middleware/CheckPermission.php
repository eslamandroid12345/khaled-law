<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$permission): Response
    {
        if (!Auth::user() || !Auth::user()->hasPermission($permission))
        {
            // Redirect or abort if the user doesn't have the necessary permission
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
