<?php

namespace Masoudi\Laravel\Cart\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Masoudi\Laravel\Cart\Cart as CartModule;
use Masoudi\Laravel\Cart\Contracts\Payable;

/**
 * @method static CartModule namespace(string $namespace)
 * @method static CartModule withSession(string $sessionName)
 * @method static CartModule add(Payable $payable, int $quantity = 1)
 * @method static CartModule remove(Payable $payable, ?int $quantity = null)
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