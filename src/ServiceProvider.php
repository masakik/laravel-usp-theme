<?php

namespace Uspdev\UspTheme;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\View;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(
        Factory $view,
        Dispatcher $events,
        Repository $config
    ) {
        $this->loadViews();
        $this->loadTranslations();
        $this->publishAssets();
        $this->publishConfig();

        // config
        View::share('title', config('laravel-usp-theme.title'));
        View::share('menu', config('laravel-usp-theme.menu'));
        View::share('dashboard_url', config('laravel-usp-theme.dashboard_url'));
        View::share('logout_method', config('laravel-usp-theme.logout_method'));
        View::share('login_url', config('laravel-usp-theme.login_url'));
        View::share('logout_url', config('laravel-usp-theme.logout_url'));
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function packagePath($path)
    {
        return __DIR__."/../$path";
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources/views');
        $this->loadViewsFrom($viewsPath, 'laravel-usp-theme');
        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/laravel-usp-theme'),
        ], 'views');
    }

    private function loadTranslations()
    {
        $translationsPath = $this->packagePath('resources/lang');
        $this->loadTranslationsFrom($translationsPath, 'laravel-usp-theme');
        $this->publishes([
            $translationsPath => base_path('resources/lang/vendor/laravel-usp-theme'),
        ], 'translations');
    }

    private function publishAssets()
    {
        $this->publishes([
            $this->packagePath('resources/assets') => public_path('vendor/laravel-usp-theme'),
        ], 'assets');
    }

    private function publishConfig()
    {
        $configPath = $this->packagePath('config/laravel-usp-theme.php');
        $this->publishes([
            $configPath => config_path('laravel-usp-theme.php'),
        ], 'config');
        $this->mergeConfigFrom($configPath, 'laravel-usp-theme');
    }

}
