<?php

namespace Masoudi\Laravel\Cart\Contracts;

use Illuminate\Support\Collection;

interface CartStorage extends Session
{
    /**
     * add item to cart
     *
     * @param Payable $payable
     * @param string $namespace
     * @param int $quantity
     * @return void
     */
    public function add(Payable $payable, string $namespace, int $quantity = 1): void;

    /**
     * remove item from cart
     *
     * @param Payable $payable
     * @param string $namespace
     * @param int|null $quantity
     * @return void
     */
    public function remove(Payable $payable, string $namespace, ?int $quantity = null): void;

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