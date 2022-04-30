<?php

namespace LaravelExportConstants;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use LaravelExportConstants\Console\ClearConstantCache;
use LaravelExportConstants\Generators\ConstantGenerator;

class LaravelExportConstantsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-export-constants');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-export-constants');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/export-constants.php' => config_path('laravel-export-constants.php'),
            ], 'export-constants');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-export-constants'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-export-constants'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-export-constants'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([ClearConstantCache::class, /* ConstantGenerator::class */]);
        }

        if ($this->app->resolved('blade.compiler')) {
            $this->registerDirective($this->app['blade.compiler']);
        } else {
            $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
                $this->registerDirective($bladeCompiler);
            });
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/export-constants.php', 'export-constants.php');

        // Register the main class to use with the facade
        $this->app->singleton(AttributeClassRegistrar::class, function ($app) {
            return new AttributeClassRegistrar(config('export-constants.namespaces'));
        });
        $this->app->singleton('laravel-export-constants', function ($app) {
            return new LaravelExportConstants($app->make(AttributeClassRegistrar::class));
        });
    }

    protected function registerDirective(BladeCompiler $bladeCompiler)
    {
        $bladeCompiler->directive('constants', function () {
            dump('regDirDir');

            return "<?php echo app('" . LaravelExportConstants::class . "')->generate() ?>";
        });
    }

}
