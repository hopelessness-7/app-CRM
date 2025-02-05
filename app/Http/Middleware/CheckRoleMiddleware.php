<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Проверяем, авторизован ли пользователь
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Получаем текущего пользователя
        $user = Auth::user();

        // Проверяем, имеет ли пользователь хотя бы одну из указанных ролей
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request); // Если роль есть, продолжаем выполнение
            }
        }

        // Если ни одна роль не подходит, возвращаем ошибку доступа
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
