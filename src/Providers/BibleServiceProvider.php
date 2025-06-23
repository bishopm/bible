<?php namespace Bishopm\Bible\Providers;

use Bishopm\Bible\Livewire\Bible;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;

class BibleServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        Config::set('session.lifetime',525600);
        Schema::defaultStringLength(191);
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'bible');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        Livewire::component('bible', Bible::class);
        Blade::componentNamespace('Bishopm\\Bible\\Resources\\Views\\Components', 'bible');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // $this->mergeConfigFrom(__DIR__.'/../../config/bible.php', 'bible');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bible'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishes assets.
        $this->publishes([
            __DIR__.'/../Resources/assets' => public_path('bible'),
          ], 'assets');
    }
}
