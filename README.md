# Laravel WordPress (JWT) User Provider Example

This is an example of how to use a WordPress site as the user provider for a Laravel app. This allows WordPress to act as the source of truth for users. 

I didn't integrate this with user registration and probably will not.

Requires a WordPress site with [the JWT authentication plugin](https://wordpress.org/plugins/jwt-auth/).

For a different approach to the same problem, [see this package](https://github.com/ahsankhatri/wordpress-auth-driver-laravel). That package requires access to WordPress' MySQL database. This example does not, instead it uses HTTPS.

## Setup

The Laravel app is in the directory "my-app".


- `composer install`
- Setup env variables
    - URL of a WordPress site's rest api
        - `WP_API_URL=https://roysivan.com/wp-json`
    - A database -- for cache and session
        -  `DB_CONNECTION=sqlite`
- Migrate
    - `php artisan migrate`
    
    
## docker-compose

__Not useful yet__

- `docker-compose up -d`

## How It Works

I [followed instructions](https://laravel.com/docs/8.x/authentication#adding-custom-user-providers) on how to create a customer user provider. It takes the supplied username and password and attempts to get a JWT token from the WordPress site. If that works, a User model is created -- in memory and cache. The password is not saved. A standard Laravel session is created. That session will be maintained as long as the user remains in the cache or the user logs out.




