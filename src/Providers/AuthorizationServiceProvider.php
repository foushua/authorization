<?php

namespace Foushua\Authorization\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Foushua\Authorization\Middlewares\RoleMiddleware;
use Foushua\Authorization\Middlewares\LevelMiddleware;
use Foushua\Authorization\Middlewares\PermissionMiddleware;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->registerBladeDirectives();
        $this->registerMiddlewares();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('authorization.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'authorization');
    }

    /**
     * Register all blade directives
     */
    protected function registerBladeDirectives()
    {
        Blade::if('role', function ($expression) {
            return Auth::user()->hasRole($expression);
        });

        Blade::if('level', function ($expression) {
            return Auth::user()->level() >= $expression;
        });
    }

    /**
     * Register middlewares
     */
    protected function registerMiddlewares()
    {
        $middlewares = [
            'role' => RoleMiddleware::class,
            'level' => LevelMiddleware::class,
        ];

        foreach ($middlewares as $name => $class) {
            app('router')->aliasMiddleware($name, $class);
        }
    }
}
