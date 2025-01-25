<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            if (!$user->hasVerifiedEmail()) {
                return response()->json([
                    'errors' => [
                        'error' => 'The email address is not confirmed, send it to the mail and confirm it. If you do not receive a message, then send a second email.',
                        'code' => 403
                    ]
                ], 403);
            }
            return $next($request);
        }

        return response()->json(['errors' => ['error' => 'Unauthorized', 'code' => 401]], 401);
    }
}
