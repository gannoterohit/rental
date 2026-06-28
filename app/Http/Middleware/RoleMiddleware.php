<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthenticated. Please login first.'
                ], 401);
            }
            return redirect('/login');
        }

        if (Auth::user()->role != $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Forbidden. You do not have ' . $role . ' access.'
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
