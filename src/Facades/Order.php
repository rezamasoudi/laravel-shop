<?php

namespace Masoudi\Laravel\Shop\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Masoudi\Laravel\Shop\Contracts\OrderInterface;

/**
 * @method static OrderInterface namespace(string $namespace)
 * @method static OrderInterface withSession(string $session)
 * @method static void remove(int $id)
 * @method static void removeByCode(string $code)
 * @method static Model getByCode(string $code)
 * @method static Collection getAll()
 * @method static Model get(int $id)
 * @method static Model create(Collection $collection, ?string $namespace = null, ?string $session = null)
 */
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