<?php

namespace Masoudi\Laravel\Shop\Storages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Shop\Contracts\CartStorage;
use Masoudi\Laravel\Shop\Contracts\Orderable;
use Masoudi\Laravel\Shop\Models\Cart;
use Masoudi\Laravel\Shop\Support\Utils;

class DatabaseStorage implements CartStorage
{
    private string $sessionName = "default";

    /**
     * remove item from cart
     *
     * @param Orderable $orderable
     * @param string $namespace
     * @param int|null $quantity
     * @return void
     */
    public function remove(Orderable $orderable, string $namespace, ?int $quantity = null): void
    {
        Cart::query()
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->when(!$quantity, function (Builder $builder) {
                $builder->delete();
            })
            ->when($quantity, function (Builder $builder) use ($quantity) {
                $cart = $builder->first();

                if (!$cart) return;

                if (!($cart->quantity - $quantity)) {
                    $builder->delete();
                    return;
                }

                $cart->decrement('quantity', $quantity);
            });
    }

    /**
     * Get name of curren session
     *
     * @return string
     */
    public function getSessionName(): string
    {
        return $this->sessionName;
    }

    /**
     * clear cart
     *
     * @param string $namespace
     * @return void
     */
    public function clear(string $namespace): void
    {
        Cart::query()
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->delete();
    }

    /**
     * get cart items
     *
     * @param string $namespace
     * @return Collection
     */
    public function all(string $namespace): Collection
    {
        $collection = collect();

        Cart::with('orderable')
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->each(function (Cart $cart) use (&$collection) {
                $orderable = $cart->getRelation('orderable');
                $orderable->quantity = $cart->getAttribute('quantity');
                $collection->add($orderable);
            });

        return $collection;
    }

    /**
     * add item to cart
     *
     * @param Orderable $orderable
     * @param string $namespace
     * @param int $quantity
     * @return void
     */
    public function add(Orderable $orderable, string $namespace, int $quantity = 1): void
    {
        $cart = Cart::query()->firstOrCreate([
            'orderable_type' => $orderable::class,
            'orderable_id' => $orderable->getOrderableID(),
            'session' => $this->getSessionName(),
            'namespace' => $namespace,
        ], [
            'quantity' => $quantity,
        ]);

        if (!$cart->wasRecentlyCreated) {
            $cart->increment('quantity', $quantity);
        }

    }

    /**
     * get cart total
     *
     * @param string $namespace
     * @return float
     */
    public function total(string $namespace): float
    {
        $total = 0.0;

        Cart::with('orderable')
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->each(function (Cart $cart) use (&$total) {
                /**
                 * @var Orderable $orderable
                 */
                $orderable = $cart->getRelation('orderable');
                $quantity = $cart->getAttribute('quantity');
                $total += Utils::calculateProductPrice($orderable->getAmount(), $orderable->getDiscount(), $quantity);
            });

        return $total;
    }

    /**
     * get cart subtotal
     * @param string $namespace
     * @return float
     */
    public function subtotal(string $namespace): float
    {
        $subtotal = 0.0;

        Cart::with('orderable')
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->each(function (Cart $cart) use (&$subtotal) {
                /**
                 * @var Orderable $orderable
                 */
                $orderable = $cart->getRelation('orderable');
                $quantity = $cart->getAttribute('quantity');
                $subtotal += Utils::calculateProductPrice($orderable->getAmount(), 0, $quantity);
            });

        return $subtotal;
    }

    /**
     * Set session name
     *
     * @param string $sessionName
     * @return void
     */
    public function setSession(string $sessionName): void
    {
        $this->sessionName = $sessionName;
    }
}