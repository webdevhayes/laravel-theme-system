<?php

namespace Webdevhayes\LaravelThemeSystem;

use Illuminate\Support\ServiceProvider;
use Webdevhayes\LaravelThemeSystem\Commands\LaravelThemeSystemCommand;

class LaravelThemeSystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-theme-system.php' => config_path('laravel-theme-system.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-theme-system'),
            ], 'views');

            $migrationFileName = 'create_laravel_theme_system_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->registerHelpers();

        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-theme-system');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-theme-system.php', 'laravel-theme-system');

        $this->app->singleton(LaravelThemeSystem::class, function () {
            return new LaravelThemeSystem();
        });

        $this->app->alias(LaravelThemeSystem::class, 'laravel-theme-system');
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        if (file_exists($file = __DIR__. '/helpers.php'))
        {
            require_once($file);
        }
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }

}
