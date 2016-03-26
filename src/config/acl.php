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
    'redirectToIndex' => true,

    'user' => '\App\User',
];