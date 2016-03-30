<?php

namespace AldoZumaran\Acl\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use AldoZumaran\Acl\Traits\RouteSupport;
use Illuminate\Support\Facades\Config;

class AclMiddleware
{
    use RouteSupport;

    public function handle($request, Closure $next)
    {
        $route = $request->route()->getName();

        if ($route) {

            $user = auth(Config::get('acl.guard', null))->user();
            if (!$user){
                if ($request->ajax() || $request->wantsJson())
                    return response('Acl configuration error', 503);
                else
                    return redirect(rtrim(Config::get('acl.route_prefix', ''),'/').'/');
            }

            list($object, $permission) = $this->getAclRouteName($route);
            
            $role_admin = Config::get('acl.role_admin', '');
            if ($role_admin != '' && $user->hasRole($role_admin))
                return $next($request);

            $email_admin = Config::get('acl.email_admin', '');
            if ($email_admin != '' && $user->email == $email_admin )
                return $next($request);

            $role = Config::get('acl.granted_roles', null);
            if ($role != null)
                $role = explode(',',$role);

            if ($role != null && $user->hasRole($role)){
                $prefix = rtrim(Config::get('acl.route_prefix',''),'/');
                if ($prefix != '') $prefix.='/';
                foreach (Config::get('acl.routes') as $route) {
                    if (str_replace('/','.',$prefix.$route) == $object){
                        return $next($request);
                    }
                }
            }
            if (!$user->hasPermission($object, $permission ,true) ) {
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
