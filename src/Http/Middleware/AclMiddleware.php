<?php

namespace AldoZumaran\Acl\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use AldoZumaran\Acl\Traits\RouteSupport;
use Illuminate\Support\Facades\Config;

class AclMiddleware
{
    use RouteSupport;

    public function handle($request, Closure $next, $role = null)
    {
        $route = $request->route()->getName();

        $user = auth(Config::get('acl.guard', null))->user();
        if ($route && $user) {

            list($object, $permission) = $this->getAclRouteName($route);
            
            $role_admin = Config::get('acl.role_admin', '');
            if ($role_admin != '' && $user->hasRole($role_admin))
                return $next($request);

            $email_admin = Config::get('acl.email_admin', '');
            if ($email_admin != '' && $user->email == $email_admin )
                return $next($request);

            if (!$user->hasPermission($object, $permission ,true) && ($role != null && !$user->hasRole($role,true))) {
                if ( Config::get('acl.redirect_to_index') && $user->hasPermission($object, 'read') )
                    return redirect()->route($object . "." . "index");
                
                $http_status = Config::get('acl.http_status', 500);
                if ($request->ajax() || $request->wantsJson())
                    return response('Unauthorized.', $http_status);
                else
                    abort($http_status);
            }
        }
        return $next($request);
    }
}
