<?php

namespace Prasudiro\ApiTokoOnline;

use Illuminate\Support\ServiceProvider;
use Prasudiro\ApiTokoOnline\API\CurlController;
use Prasudiro\ApiTokoOnline\Marketplace\ShopeeController;
use Prasudiro\ApiTokoOnline\Marketplace\TokpedController;

class ApiTokoOnlineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton('shopeeapi', function()
      {
        return new ShopeeController;
      });

      $this->app->singleton('tokpedapi', function()
      {
        return new TokpedController;
      });

      $this->app->singleton('client', function() 
      {
        return $data;
      });

      $this->app->make('Prasudiro\ApiTokoOnline\API\CurlController');
      $this->app->make('Prasudiro\ApiTokoOnline\Marketplace\ShopeeController');
    }
}
