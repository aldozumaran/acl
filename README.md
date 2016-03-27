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
    
And create acl tables: 
    
    /*
        //Optional: use seed (AclTableSeeder)
        // Create default permissions (read, update, create, destroy),
        // Create super-admin role
        // Create test route
        // Create default user
        // Add permissions to default user for test route

        //Add in database/seeds/DatabaseSeeder.php

        $this->call(AclTableSeeder::class);

        //Add in database/factories/ModelFactory.php

        $factory->define(App\Models\Acl\Role::class, function (Faker\Generator $faker) {
            return [
                'code' => $faker->word,
                'name' => $faker->name,
                'description' => $faker->paragraph,
            ];
        });
        $factory->define(App\Models\Acl\Permission::class, function (Faker\Generator $faker) {
            return [
                'code' => $faker->word,
                'name' => $faker->name,
                'description' => $faker->paragraph,
            ];
        });
        $factory->define(App\Models\Acl\Section::class, function (Faker\Generator $faker) {
            return [
                'code' => $faker->word,
                'name' => $faker->name,
                'description' => $faker->paragraph,
            ];
        });
        $factory->define(App\Models\Acl\PermissionRoleSection::class, function (Faker\Generator $faker) {
            return [
                'permission_id' => 1,
                'role_id' => 1,
                'section_id' => 1,
            ];
        });
        $factory->define(App\Models\Acl\PermissionSectionUser::class, function (Faker\Generator $faker) {
            return [
                'permission_id' => 1,
                'section_id' => 1,
                'user_id' => 1,
            ];
        });
    */
     
    composer dump-autoload

    php artisan migrate --seed

Change .env file 

    CACHE_DRIVER=array
    
Add ACL routes and test route
    
    Route::group(['middleware' => ['web']], function () {
        \Acl::routes();

        Route::group(['middleware' => ['auth','acl']], function () {
            Route::resource('test/custom','CustomController'); // TEST ROUTE
        });
    });



Default Configuration in config/acl.php
    
    //Set your named routes <b>permissions</b> (route actions), defaults are:
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

    //If permission not exists, redirect to index
    'redirect_to_index' => true,
    
    // L5.2 Guard auth
    'guard' => 'web',

    //Set the auth model namespace in config/acl.php
    'user' => '\App\User',
    
    //route acl prefix . EX. admin/ set admin
    'route_prefix' => '', 

    // acl urls
    'routes' => [
        'roles' => 'acl/roles',
        'users' => 'acl/users',
        'sections' => 'acl/sections',
        'permissions' => 'acl/permissions',
        'index' => 'acl',
    ],

    // roles with access to acl
    'granted_roles' => '', // 'admin' or 'admin,webmaster' or ['admin','webmaster']

    // super admin role
    'role_admin' => 'super-admin',
    'email_admin' => 'i@am.me',

    // http status error 
    'http_status' => 403,


# Usage


Go to <b>/acl/</b> (Default configuration)

This plugin works with named routes 

Create a <b>TEST ROUTE</b> controller

    php artisan make:controller CustomController --resource


    // Route::resource('test/custom','CustomController');
    
generate 
<b>test.custom</b>.index, 
<b>test.custom</b>.create,
<b>test.custom</b>.store, 
...
    
Add in Section: /acl/sections (prefix resource controller) or (use AclTableSeeder)

    test.custom

    
Add Permissions in /acl/permissions or (use AclTableSeeder)

    read, update, create, destroy


Add Roles in /acl/roles or (use AclTableSeeder)
    
