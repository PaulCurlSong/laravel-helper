<?php 
namespace MingYu\LaravelHelper\Providers;

use Illuminate\Support\ServiceProvider;

class HBaseProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('hadoop.hbase', function ($app) {
            return new \MingYu\LaravelHelper\Services\HBaseService($app['config']['database']['hbase']);
        });
    }
}