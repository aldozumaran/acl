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

Add test route 

    Route::resource('test/custom','CustomController');
    
    
