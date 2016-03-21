# acl
Laravel 5.2 acl

# Installation

Add to composer.json
    
    "aldozumaran/acl": "dev-master"
    
Run
    "composer update"
    
Add to config/app.php providers


    AldoZumaran\Acl\AclServiceProvider::class,
          

Add to config/app.php aliases
        
          
    'Acl' => AldoZumaran\Acl\Facades\Acl::class,


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
    

