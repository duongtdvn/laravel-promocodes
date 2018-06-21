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
        $this->publishes([
            __DIR__ . '/../config/promocodes.php' => config_path('promocodes.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/2018_06_20_000000_create_promocodes_table.php'
        ], 'migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/promocodes.php', 'promocodes'
        );

        $this->app->singleton(Promocodes::class, function ($app) {
            return new Promocodes();
        });

        $this->app->alias(Promocodes::class, 'promocodes');
    }
}
