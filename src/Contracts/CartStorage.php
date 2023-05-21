<?php

namespace Masoudi\Laravel\Shop\Contracts;

use Illuminate\Support\Collection;

interface CartStorage extends Session
{
    /**
     * add item to cart
     *
     * @param Orderable $orderable
     * @param string $namespace
     * @param int $quantity
     * @return void
     */
    public function add(Orderable $orderable, string $namespace, int $quantity = 1): void;

    /**
     * remove item from cart
     *
     * @param Orderable $orderable
     * @param string $namespace
     * @param int|null $quantity
     * @return void
     */
    public function remove(Orderable $orderable, string $namespace, ?int $quantity = null): void;

    /**
     * clear cart
     *
     * @param string $namespace
     * @return void
     */
    public function clear(string $namespace): void;

    /**
     * get cart items
     *
     * @param string $namespace
     * @return Collection
     */
    public function all(string $namespace): Collection;

    /**
     * get cart total
     *
     * @param string $namespace
     * @return float
     */
    public function total(string $namespace): float;

    /**
     * get cart subtotal
     * @param string $namespace
     * @return float
     */
    public function subtotal(string $namespace): float;
}