<?php

namespace Masoudi\Laravel\Cart;

use Illuminate\Support\Collection;
use Masoudi\Laravel\Cart\Contracts\CartStorage;
use Masoudi\Laravel\Cart\Contracts\Payable;

class Cart
{

    /**
     * Create instance of cart
     *
     * @param CartStorage $storage
     * @param string $namespace
     */
    public function __construct(private CartStorage $storage, private string $namespace)
    {
        //
    }

    /**
     * Set new namespace
     *
     * @param string $namespace
     * @return $this
     */
    public function namespace(string $namespace): Cart
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Set storage session name
     *
     * @param string $sessionName
     * @return Cart
     */
    public function withSession(string $sessionName): Cart
    {
        $this->storage->setSession($sessionName);
        return $this;
    }

    /**
     * Add a payable to cart
     *
     * @param Payable $payable
     * @param int $quantity
     * @return Cart
     */
    public function add(Payable $payable, int $quantity = 1): Cart
    {
        $this->storage->add($payable, $this->namespace, $quantity);
        return $this;
    }

    /**
     * Remove payable from cart
     *
     * @param Payable $payable
     * @param int|null $quantity
     * @return $this
     */
    public function remove(Payable $payable, ?int $quantity = null): Cart
    {
        $this->storage->remove($payable, $this->namespace, $quantity);
        return $this;
    }

    /**
     * Clear all payable data from cart
     *
     * @return $this
     */
    public function clear(): Cart
    {
        $this->storage->clear($this->namespace);
        return $this;
    }

    /**
     * Get all cart items
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->storage->all($this->namespace);
    }

    /**
     * Get total price of cart
     *
     * @return float
     */
    public function total(): float
    {
        return $this->storage->total($this->namespace);
    }

    /**
     * Get subtotal price of cart
     *
     * @return float
     */
    public function subtotal(): float
    {
        return $this->storage->subtotal($this->namespace);
    }

}