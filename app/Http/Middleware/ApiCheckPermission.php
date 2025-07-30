<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiCheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('sanctum')->user(); // যদি Sanctum ইউজ করো

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->load('roles.permissions');

        if (!$user->hasPermission($permission)) {
            return response()->json(['message' => 'Forbidden: You don\'t have permission'], 403);
        }

        return $next($request);
    }
}
