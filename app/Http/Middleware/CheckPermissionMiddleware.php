<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check() || !Auth::user()->hasPermission($permission)) {
            return response()->json([
                'errors' => [
                    'error' => 'No access, not enough rights.',
                    'code' => 403
                ]
            ]);
        }

        return $next($request);
    }
}
