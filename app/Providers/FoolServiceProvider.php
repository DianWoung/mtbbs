<?php

namespace App\Providers;

use App\Contracts\FoolContract;
use App\Services\FoolService;
use Illuminate\Support\ServiceProvider;

class FoolServiceProvider extends ServiceProvider
{
    protected $defer = true;



    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $GLOBALS['fool'] = 'dianwang';
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('fool', FoolService::class);
        $this->app->bind(FoolContract::class, FoolService::class);
    }

    public function provides()
    {
        return ['fool'];
    }
}
