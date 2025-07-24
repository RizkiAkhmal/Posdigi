<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if (!$user || !method_exists($user, 'hasRole') || !$user->hasRole($role)) {
            abort(403, 'Unauthorized - You do not have permission to access this area');
        }

        return $next($request);
    }
}
