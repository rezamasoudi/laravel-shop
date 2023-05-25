<?php

namespace Masoudi\Laravel\Shop;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Shop\Contracts\CartStorage;
use Masoudi\Laravel\Shop\Contracts\Orderable;
use Masoudi\Laravel\Shop\Exceptions\EmptyCartException;
use Masoudi\Laravel\Shop\Exceptions\InvalidClassException;

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
     * Add a orderable to cart
     *
     * @param Orderable $orderable
     * @param int $quantity
     * @return Cart
     */
    public function add(Orderable $orderable, int $quantity = 1): Cart
    {
        $this->storage->add($orderable, $this->namespace, $quantity);
        return $this;
    }

    /**
     * Remove orderable from cart
     *
     * @param Orderable $orderable
     * @param int|null $quantity
     * @return $this
     */
    public function remove(Orderable $orderable, ?int $quantity = null): Cart
    {
        $this->storage->remove($orderable, $this->namespace, $quantity);
        return $this;
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

    /**
     * @param bool $cleanup
     * @return Model
     * @throws InvalidClassException|EmptyCartException|Exception
     */
    public function createOrder(bool $cleanup = true): Model
    {
        $order = \Masoudi\Laravel\Shop\Facades\Order::create(
            collection: $this->all(),
            namespace: $this->namespace,
            session: $this->storage->getSessionName()
        );

        if ($cleanup) {
            // cleanup cart
            $this->clear();
        }

        return $order;
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
     * Clear all orderable data from cart
     *
     * @return $this
     */
    public function clear(): Cart
    {
        $this->storage->clear($this->namespace);
        return $this;
    }

}