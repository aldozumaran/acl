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
    ],
    'redirectToIndex' => true,

    'user' => '\App\User',
];