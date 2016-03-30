<?php

namespace AldoZumaran\Acl;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;

class Acl 
{

    public function route($route, $action = 'index', $params = [], $routeing = true)
    {
        $prefix = Config::get('acl.route_prefix','');
        if ($prefix!='') $prefix.='.';

        $route = str_replace("/",".",Config::get('acl.routes.'.$route,'acl/'.$route).'/'.$action);

        //return $routeing ? isset($param) ? route($prefix.$route, $param) : route($prefix.$route) : $prefix.$route;
        return 	$routeing ? 
					route($prefix.$route, $params)
					: $prefix.$route;
    }

    public function routes()
    {
    	$granted_roles = Config::get('acl.granted_roles',null);
    	$mdw = $granted_roles ? 'acl:'.(is_array($granted_roles) ? implode(',', $granted_roles) : $granted_roles) : 'acl';
    	$prefix = Config::get('acl.route_prefix','');

    	
    	\Route::group( [ 'middleware' => [$mdw], 'prefix' => $prefix ], function () {
	        
            $permissions = Config::get('acl.routes.permissions','acl/permissions');
            $sections = Config::get('acl.routes.sections','acl/sections');
            $roles = Config::get('acl.routes.roles','acl/roles');
            $users = Config::get('acl.routes.users','acl/users');
            $acl = Config::get('acl.routes.index','acl');

	        \Route::put($roles.'/permission', '\AldoZumaran\Acl\Http\Controllers\AclRolesController@permission')
	        	->name(\Acl::route('roles','read_update',[],false));
	        \Route::put($users.'/permission', '\AldoZumaran\Acl\Http\Controllers\AclUsersController@permission')
	        	->name(\Acl::route('users','read_update',[],false));


	        \Route::resource($permissions, '\AldoZumaran\Acl\Http\Controllers\AclPermissionsController');
	        \Route::resource($sections, '\AldoZumaran\Acl\Http\Controllers\AclSectionsController');
	        \Route::resource($roles, '\AldoZumaran\Acl\Http\Controllers\AclRolesController');
	        \Route::resource($users, '\AldoZumaran\Acl\Http\Controllers\AclUsersController');
	        \Route::resource($acl, '\AldoZumaran\Acl\Http\Controllers\AclController');
	    });
    }
}