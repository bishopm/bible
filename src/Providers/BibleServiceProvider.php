<?php

namespace Bishopm\Bible\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Form;
use Bishopm\Bible\Repositories\SettingsRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Gate;

class BibleServiceProvider extends ServiceProvider
{
    private $settings;

    protected $commands = [
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, SettingsRepository $settings)
    {
        $this->settings=$settings;
        Schema::defaultStringLength(255);
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../Http/api.routes.php';
            require __DIR__.'/../Http/web.routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'bible');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->publishes([__DIR__.'/../Assets' => public_path('vendor/bishopm'),], 'public');
        config(['auth.providers.users.model'=>'Bishopm\Bible\Models\User']);
        if (Schema::hasTable('settings')) {
            /*$finset=$settings->makearray();
            if (($settings->getkey('site_name'))<>"Invalid") {
                config(['app.name'=>$settings->getkey('site_name')]);
            }*/
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        $this->app->bind('setting', function () {
            return new \Bishopm\Bible\Repositories\SettingsRepository(new \Bishopm\Bible\Models\Setting());
        });
        AliasLoader::getInstance()->alias("Setting", 'Bishopm\Bible\Models\Facades\Setting');
        AliasLoader::getInstance()->alias("Socialite", 'Laravel\Socialite\Facades\Socialite');
        AliasLoader::getInstance()->alias("JWTFactory", 'Tymon\JWTAuth\Facades\JWTFactory');
        AliasLoader::getInstance()->alias("JWTAuth", 'Tymon\JWTAuth\Facades\JWTAuth');
        AliasLoader::getInstance()->alias("UserVerification", 'Jrean\UserVerification\Facades\UserVerification');
        AliasLoader::getInstance()->alias("Form", 'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias("HTML", 'Collective\Html\HtmlFacade');
        $this->app['router']->aliasMiddleware('isverified', 'Bishopm\Bible\Middleware\IsVerified');
        $this->app['router']->aliasMiddleware('handlecors', 'Barryvdh\Cors\HandleCors');
        $this->app['router']->aliasMiddleware('jwt.auth', 'Tymon\JWTAuth\Middleware\GetUserFromToken');
        $this->app['router']->aliasMiddleware('role', 'Spatie\Permission\Middlewares\RoleMiddleware');
        $this->app['router']->aliasMiddleware('permission', 'Spatie\Permission\Middlewares\PermissionMiddleware');
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Bishopm\Bible\Repositories\ActionsRepository',
            function () {
                $repository = new \Bishopm\Bible\Repositories\ActionsRepository(new \Bishopm\Bible\Models\Action());
                return $repository;
            }
        );

        $this->app->bind(
            'Bishopm\Bible\Repositories\SettingsRepository',
            function () {
                $repository = new \Bishopm\Bible\Repositories\SettingsRepository(new \Bishopm\Bible\Models\Setting());
                return $repository;
            }
        );
    }
}
