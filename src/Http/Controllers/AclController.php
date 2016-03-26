<?php

namespace AldoZumaran\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Acl\Role;
use App\Models\Auth\User;

class AclController extends Controller{

    public function index()
    {
        return view('acl::index');
    }
    public function getCheckpermission()
    {
        // Check User Role
       // $user = User::findOrFail(1);
        //dd($user->hasRole('super-admin'));


        // Check User Permission
        $user = User::findOrFail(1);

        // Add User Permission
        dd($user->attachPerm('test','read'));

        // Remove User Permission
        dd($user->detachPerm('test','read'));

        //Check User Role Permission and User Permission
        dd($user->hasPermission('test',['destroy','read','create','update'],true));

        //Check User Permission
        dd($user->hasUserPermission('test',['destroy','read','create'],true));


        //Check User Role Permission
        dd($user->hasRolePermission('test',['destroy','update','create'],true));

    }
}