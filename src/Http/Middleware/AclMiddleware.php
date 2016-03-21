<?php

namespace AldoZumaran\Acl\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use AldoZumaran\Acl\Traits\RouteSupport;
use Illuminate\Support\Facades\Config;

class AclMiddleware
{
    use RouteSupport;

    public function handle($request, Closure $next, $guard = null)
    {
        $route = $request->route()->getName();
        if ($route) {
            $user = Auth::guard($guard)->user();

            list($object, $permission) = $this->getAclRouteName($route);

            if (!$user->hasPermission($object, $permission)) {
                if ( Config::get('acl.redirectToIndex') && $user->hasPermission($object, 'read') )
                    return redirect()->route($object . "." . "index");

                if ($request->ajax() || $request->wantsJson())
                    return response('Unauthorized.', 403);
                else
                    abort(403);
            }
        }
        return $next($request);
    }
}
