<?php
/**
 * Created by PhpStorm.
 * User: truongduong
 * Date: 6/20/18
 * Time: 4:53 PM
 */

namespace DuongTD\Promocodes;

use Illuminate\Support\ServiceProvider;

class PromocodesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        if (! class_exists('CreatePromocodesTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_promocodes_table.php.stub' => database_path('migrations/'.$timestamp.'_create_promocodes_table.php')
            ], 'migrations');
        }

        $this->publishes([
            __DIR__.'/../config/promocodes.php' => config_path('promocodes.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/promocodes.php', 'promocodes'
        );

        $this->app->singleton(Promocodes::class, function ($app) {
            return new Promocodes();
        });

        $this->app->alias(Promocodes::class, 'promocodes');
    }
}
