<?php

namespace Masoudi\Laravel\Shop\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Masoudi\Laravel\Shop\Cart as CartModule;
use Masoudi\Laravel\Shop\Contracts\Orderable;

/**
 * @method static CartModule namespace(string $namespace)
 * @method static CartModule withSession(string $sessionName)
 * @method static CartModule add(Orderable $payable, int $quantity = 1)
 * @method static CartModule remove(Orderable $payable, ?int $quantity = null)
 * @method static CartModule clear()
 * @method static Collection all()
 * @method static float total()
 * @method static float subtotal()
 */
class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return "laravel-cart";
    }

}