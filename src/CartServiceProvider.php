<?php

namespace Masoudi\Laravel\Cart;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Masoudi\Laravel\Cart\Contracts\CartStorage;
use Masoudi\Laravel\Cart\Storages\DatabaseStorage;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $date = date("Y_m_d_His");

        $this->publishes([
            __DIR__ . "/../export/migrations/create_carts_table.php" =>
                database_path("migrations/{$date}_create_carts_table.php")
        ], "laravel-cart");
    }


    public function register()
    {
        $this->app->when(Cart::class)
            ->needs(CartStorage::class)
            ->give(function () {
                return new DatabaseStorage();
            });

        $this->app->when(Cart::class)
            ->needs('$namespace')
            ->give("default");


        $this->app->bind("laravel-cart", function (Application $application) {
            return $application->make(Cart::class);
        });

    }

}