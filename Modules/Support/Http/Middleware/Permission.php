<?php

namespace Modules\Support\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if (!Auth::check() || !$request->user()->hasPermission(explode('|', $permissions))) {
            abort(403);
        }

        return $next($request);
    }
}
