<?php

namespace Masoudi\Laravel\Shop\Contracts;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Shop\Exceptions\EmptyCartException;
use Masoudi\Laravel\Shop\Exceptions\InvalidClassException;
use Masoudi\Laravel\Shop\Exceptions\OrderNotFoundException;

interface OrderInterface
{
    /**
     * Create A namespace for add order
     *
     * @param string $namespace
     * @return OrderInterface
     */
    public function namespace(string $namespace): OrderInterface;

    /**
     * Group orders with session (Example value: user id)
     *
     * @param string $session
     * @return OrderInterface
     */
    public function withSession(string $session): OrderInterface;

    /**
     * Remove order by id
     *
     * @param int $id
     * @return void
     * @throws OrderNotFoundException
     */
    public function remove(int $id): void;

    /**
     * Remove order by code
     *
     * @param string $code
     * @return void
     * @throws OrderNotFoundException
     */
    public function removeByCode(string $code): void;


    /**
     * Get order by id
     *
     * @param int $id
     * @param bool $loadItems
     * @return Model
     * @throws OrderNotFoundException
     */
    public function get(int $id, bool $loadItems = false): Model;

    /**
     * Get order by order_code
     *
     * @param string $code
     * @param bool $loadItems
     * @return Model
     * @throws OrderNotFoundException
     */
    public function getByCode(string $code, bool $loadItems = false): Model;

    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Create new order
     *
     * @param Collection $collection
     * @param string|null $namespace
     * @param string|null $session
     * @return Model
     * @throws InvalidClassException
     * @throws EmptyCartException
     * @throws Exception
     */
    public function create(Collection $collection, ?string $namespace = null, ?string $session = null): Model;

}