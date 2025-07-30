<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = Auth::user();

        if (!$user) {
            
            abort(403, 'Unauthorized');
        }
    dd(get_class($user)); 

        if (!$user->hasPermission($permission)) {
            
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
