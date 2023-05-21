<?php

namespace Masoudi\Laravel\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Shop\Contracts\OrderInterface;
use Masoudi\Laravel\Shop\Exceptions\OrderNotFoundException;
use Masoudi\Laravel\Shop\Models\Order as OrderModel;

class Order implements OrderInterface
{

    private string $namespace = 'default';
    private string $session = 'default';

    /**
     * Create A namespace for add order
     *
     * @param string $namespace
     * @return OrderInterface
     */
    public function namespace(string $namespace): OrderInterface
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Group orders with session (Example value: user id)
     *
     * @param string $session
     * @return OrderInterface
     */
    public function withSession(string $session): OrderInterface
    {
        $this->session = $session;
        return $this;
    }

    /**
     * Remove order by id
     *
     * @param int $id
     * @return void
     * @throws OrderNotFoundException
     */
    public function remove(int $id): void
    {
        $order = OrderModel::query()->where('id', $id)->first();

        // throw exception if order not found
        if (!$order) {
            throw new OrderNotFoundException("Remove order failed. because order id #$id not found.");
        }

        // remove order
        $order->delete();
    }

    /**
     * Remove order by code
     *
     * @param string $code
     * @return void
     * @throws OrderNotFoundException
     */
    public function removeByCode(string $code): void
    {
        $order = OrderModel::query()->where('code', $code)->first();

        // throw exception if order not found
        if (!$order) {
            throw new OrderNotFoundException("Remove order failed. because order code #$code not found.");
        }

        // remove order
        $order->delete();
    }

    /**
     * Get order by order_code
     *
     * @param string $code
     * @return Model
     * @throws OrderNotFoundException
     */
    public function getByCode(string $code): Model
    {
        $order = OrderModel::query()->where('code', $code)->first();

        // throw exception if order not found
        if (!$order) {
            throw new OrderNotFoundException("Remove order failed. because order code #$code not found.");
        }

        // remove order
        return $order;
    }

    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return OrderModel::query()
            ->where('namespace', $this->namespace)
            ->where('session', $this->session)
            ->get();
    }

    /**
     * Get order by id
     *
     * @param int $id
     * @return Model
     * @throws OrderNotFoundException
     */
    public function get(int $id): Model
    {
        $order = OrderModel::query()->where('id', $id)->first();

        // throw exception if order not found
        if (!$order) {
            throw new OrderNotFoundException("Get order failed. because order id #$id not found.");
        }

        return $order;
    }
}