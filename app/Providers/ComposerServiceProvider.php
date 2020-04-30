<?php

namespace App\Providers;

use App\ViewComposers\SiteWideData;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['web.*'], 'App\ViewComposers\SiteWideData'
        );
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SiteWideData::class);
    }

}
