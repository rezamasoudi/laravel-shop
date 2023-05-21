<?php

namespace Masoudi\Laravel\Cart\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Cart\Exceptions\OrderNotFoundException;

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
     * @return Model
     */
    public function get(int $id): Model;

    /**
     * Get order by order_code
     *
     * @param string $code
     * @return Model
     */
    public function getByCode(string $code): Model;

    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAll(): Collection;

}