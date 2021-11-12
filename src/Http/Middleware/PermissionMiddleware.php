<?php

namespace KaziShahin\Acl\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        if (!Auth::check()) {
            return redirect('login');
        }

        if (!$request->user()->can($routeName)) {
            if ($request->ajax()) {
                return response('Access denied!', 401);
            }
            abort(401);
        }

        return $next($request);
    }
}
