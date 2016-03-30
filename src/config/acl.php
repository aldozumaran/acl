<?php

return [
    'permissions' => [
        'index' => 'read',
        'create' => 'create',
        'store' => 'create',
        'show' => 'read',
        'edit' => 'update',
        'update' => 'update',
        'destroy' => 'destroy',
        'read_update' => ['read','update'],
    ],
    'redirect_to_index' => true,
    'guard' => 'web',
    'user' => '\App\Models\Auth\User',
    'route_prefix' => '',
    'routes' => [
        'roles' => 'acl/roles',
        'users' => 'acl/users',
        'sections' => 'acl/sections',
        'permissions' => 'acl/permissions',
        'index' => 'acl',
    ],
    'granted_roles' => '',
    'role_admin' => 'super-admin',
    'email_admin' => 'i@am.me',
    'http_status' => 403,
];