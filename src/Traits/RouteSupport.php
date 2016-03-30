<?php
namespace AldoZumaran\Acl\Traits;

use Illuminate\Support\Facades\Config;

trait RouteSupport {
     public static function getAclRouteName($resourcedRoute){
        $resourcedRouteArray = explode('.', $resourcedRoute);

        $permission = array_pop($resourcedRouteArray);
        $object = implode('.', $resourcedRouteArray);

        $permission = Config::get('acl.permissions.'.strtolower($permission), 'denied');

        return [$object, $permission];
    }
    public function getAclRouteController($route){
        $prefix = Config::get('acl.route_prefix','');
        if ($prefix!='')
            $prefix.='.';
        return $prefix.$route;
    }
}