<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        // Check if user is authenticated
        if (!$user) {
            abort(403, 'Unauthorized - Please login first.');
        }
        
        // Check if user has any of the required roles
        if (!in_array($user->roleType, $roles)) {
            abort(403, 'Unauthorized - You do not have access to this area.');
        }

        return $next($request);
    }
}