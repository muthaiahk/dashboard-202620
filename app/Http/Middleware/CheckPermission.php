<?php

namespace App\Http\Middleware;

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
    public function handle(Request $request, Closure $next, $module, $action = 'is_read'): Response
    {
        if (!$request->user() || !$request->user()->hasPermission($module, $action)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to ' . $module
                ], 403);
            }
            
            return abort(403, 'Unauthorized access to ' . $module);
        }

        return $next($request);
    }
}
