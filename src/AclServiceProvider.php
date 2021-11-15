<?php

namespace KaziShahin\Acl;

use KaziShahin\Acl\Helpers\AclHelper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        AclHelper::getPermissions()->map(function ($permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });
//        $this->publishes([UnitTestHelperJson::class,UnitTestHelper::class]);
//        $this->loadViewsFrom(__DIR__ . '/resources/views', 'errorlog');
//        $this->publishes([
//            __DIR__ . '/resources/views' => base_path('resources/views/acolyte/errorlog'),
//            __DIR__ . '/database/migrations' => base_path('database/migrations'),
//            __DIR__ . '/config' => base_path('config'),
//        ],'kazi-shahin-acl');
    }
}
