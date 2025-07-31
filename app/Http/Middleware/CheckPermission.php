<?php

namespace App\Http\Middleware;

use App\Models\User;
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

        $userId = $request->session()->get('userId');
        $user = User::find($userId);


        if (!$user) {
            
            abort(403, 'Unauthorized');
        }


        if (!$user->hasPermission($permission)) {
            
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
