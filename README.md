# Acl
Laravel 5.2 Acl

# Installation

Add to composer.json
    
    "aldozumaran/acl": "dev-master"
    
Run
    "composer update"
    
Add to config/app.php providers


    AldoZumaran\Acl\AclServiceProvider::class,
          

Add to config/app.php aliases
        
          
    'Acl' => AldoZumaran\Acl\Facades\Acl::class,

Add in kernel.php

    'acl' => \AldoZumaran\Acl\Http\Middleware\AclMiddleware::class,


In User model add this Trait

    use AldoZumaran\Acl\Traits\AclUserTrait;
    class User extends Authenticatable
    {
    
        use AclUserTrait;
     
Publish views, Model...

    php artisan vendor:publish
    
Run "composer dump-autoload"

And create acl tables:
    
    php artisan migrate

Change .env file 

    CACHE_DRIVER=array
    

Go to "laravel.app/acl/roles"

# Usage

This plugin works with named routes

Add Roles in /acl/roles

Config your named routes <b>permissions</b> in config/acl.php

    'permissions' => [
        'index' => 'read',
        'create' => 'create',
        'store' => 'create',
        'show' => 'read',
        'edit' => 'update',
        'update' => 'update',
        'destroy' => 'destroy',
        ...
    ],
    
Add Permissions in /acl/permissions

    read, update, create, destroy
    
Add Section in /acl/sections

    test.custom

Add ACL routes and test route
        
    
    Route::group(['middleware' => ['web']], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::resource('acl/permissions', 'AldoZumaran\Acl\Http\Controllers\AclPermissionsController');
            Route::resource('acl/sections', 'AldoZumaran\Acl\Http\Controllers\AclSectionsController');
            Route::put('acl/roles/permission', 'AldoZumaran\Acl\Http\Controllers\AclRolesController@permission')->name('acl.roles.read_update');
            Route::resource('acl/roles', 'AldoZumaran\Acl\Http\Controllers\AclRolesController');
            Route::put('acl/users/permission', 'AldoZumaran\Acl\Http\Controllers\AclUsersController@permission')->name('acl.users.read_update');
            Route::resource('acl/users', 'AldoZumaran\Acl\Http\Controllers\AclUsersController');
        
            Route::resource('acl', 'AldoZumaran\Acl\Http\Controllers\AclController');
            
            Route::group(['middleware' => 'acl'], function () {
                Route::resource('test/custom','CustomController'); // TEST ROUTE
            });
        });
    });



    // Add User Permission
    //Params: section, permission
    dd($user->attachPerm('test','read'));

    // Remove User Permission
    dd($user->detachPerm('test','read'));
        
    //Check User Role Permission and User Permission
    dd($user->hasPermission('test',['destroy','read','create','update'],true));

    //Check User Permission
    dd($user->hasUserPermission('test',['destroy','read','create'],true));


    //Check User Role Permission
    dd($user->hasRolePermission('test',['destroy','update','create'],true));
    

    
    
