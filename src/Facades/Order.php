<?php

namespace Masoudi\Laravel\Shop\Facades;

use Illuminate\Support\Facades\Facade;
use Masoudi\Laravel\Shop\Contracts\OrderInterface;

class Order extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return OrderInterface::class;
    }

}