# auto-test

# Installation:

- `composer require kazi-shahin/acl`
- `php artisan vendor:publish --tag=kazi-shahin-acl`
- `php artisan migrate`
- Add `'permission' => \KaziShahin\Acl\Http\Middleware\PermissionMiddleware::class,` inside `$routeMiddleware` of `Kernel.php`
- use `KaziShahin\Acl\Traits\HasPermissionsTrait` in user model

# Usage

- use `permission` middleware in your route and add route names and permission accordingly. 
