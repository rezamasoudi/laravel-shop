<?php

namespace Masoudi\Laravel\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Shop\Contracts\CartStorage;
use Masoudi\Laravel\Shop\Contracts\Orderable;

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
     * @param Orderable $payable
     * @param int $quantity
     * @return Cart
     */
    public function add(Orderable $payable, int $quantity = 1): Cart
    {
        $this->storage->add($payable, $this->namespace, $quantity);
        return $this;
    }

    /**
     * Remove payable from cart
     *
     * @param Orderable $payable
     * @param int|null $quantity
     * @return $this
     */
    public function remove(Orderable $payable, ?int $quantity = null): Cart
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

    public function createOrder(): Model
    {

    }

}