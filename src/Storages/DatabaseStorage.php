<?php

namespace Masoudi\Laravel\Cart\Storages;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Masoudi\Laravel\Cart\Contracts\CartStorage;
use Masoudi\Laravel\Cart\Contracts\Payable;
use Masoudi\Laravel\Cart\Models\Cart;
use Masoudi\Laravel\Cart\Support\Utils;

class DatabaseStorage implements CartStorage
{
    private string $sessionName = "default";

    /**
     * remove item from cart
     *
     * @param Payable $payable
     * @param string $namespace
     * @param int|null $quantity
     * @return void
     */
    public function remove(Payable $payable, string $namespace, ?int $quantity = null): void
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

        Cart::with('payable')
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->each(function (Cart $cart) use (&$collection) {
                $payable = $cart->getRelation('payable');
                $payable->quantity = $cart->getAttribute('quantity');
                $collection->add($payable);
            });

        return $collection;
    }

    /**
     * add item to cart
     *
     * @param Payable $payable
     * @param string $namespace
     * @param int $quantity
     * @return void
     */
    public function add(Payable $payable, string $namespace, int $quantity = 1): void
    {
        $cart = Cart::query()->firstOrCreate([
            'payable_type' => $payable::class,
            'payable_id' => $payable->getPayableID(),
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

        Cart::with('payable')
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->each(function (Cart $cart) use (&$total) {
                /**
                 * @var Payable $payable
                 */
                $payable = $cart->getRelation('payable');
                $quantity = $cart->getAttribute('quantity');
                $total += Utils::calculateProductPrice($payable->getAmount(), $payable->getDiscount(), $quantity);
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

        Cart::with('payable')
            ->where('session', $this->getSessionName())
            ->where('namespace', $namespace)
            ->each(function (Cart $cart) use (&$subtotal) {
                /**
                 * @var Payable $payable
                 */
                $payable = $cart->getRelation('payable');
                $quantity = $cart->getAttribute('quantity');
                $subtotal += Utils::calculateProductPrice($payable->getAmount(), 0, $quantity);
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