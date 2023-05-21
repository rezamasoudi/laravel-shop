<?php

namespace Masoudi\Laravel\Shop;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Masoudi\Laravel\Shop\Contracts\CartStorage;
use Masoudi\Laravel\Shop\Contracts\OrderInterface;
use Masoudi\Laravel\Shop\Events\OrderPaid;
use Masoudi\Laravel\Shop\Listeners\ProcessOrder;
use Masoudi\Laravel\Shop\Storages\DatabaseStorage;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $date = date("Y_m_d_His");

        $this->publishes([
            // cart migration
            __DIR__ . "/../export/migrations/create_carts_table.php" =>
                database_path("migrations/{$date}_create_carts_table.php"),
            // order migration
            __DIR__ . "/../export/migrations/create_order_tables.php" =>
                database_path("migrations/{$date}_create_order_tables.php")
        ], "laravel-shop");

        Event::listen(OrderPaid::class, ProcessOrder::class);

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

        $this->app->bind(OrderInterface::class, function (Application $application) {
            return $application->make(Order::class);
        });

    }

}