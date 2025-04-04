<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        //$role = [1, 2, 3];
        $user = Auth::guard('api')->user();
        Log::debug("User role_id: {$user->role_id}");
        Log::debug("Expected role: ", (array)$role); 
        
        if ($user && in_array($user->role_id, $role)) {
            return $next($request);
        }
        
        return response()->json([
            'result' => false,
            'msg' => "Acceso no autorizado"
        ], 403);
    }
}
