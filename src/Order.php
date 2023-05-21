<?php

namespace Masoudi\Laravel\Shop;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Masoudi\Laravel\Shop\Contracts\Orderable;
use Masoudi\Laravel\Shop\Contracts\OrderInterface;
use Masoudi\Laravel\Shop\Exceptions\EmptyCartException;
use Masoudi\Laravel\Shop\Exceptions\InvalidClassException;
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
     * @param bool $loadItems
     * @return Model
     * @throws OrderNotFoundException
     */
    public function getByCode(string $code, bool $loadItems = false): Model
    {
        $relations = [];
        if ($loadItems) {
            $relations[] = 'items';
        }

        $order = OrderModel::with($relations)->where('code', $code)->first();

        // throw exception if order not found
        if (!$order) {
            throw new OrderNotFoundException("Get order failed. because order code #$code not found.");
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
     * @param bool $loadItems
     * @return Model
     * @throws OrderNotFoundException
     */
    public function get(int $id, bool $loadItems = false): Model
    {
        $relations = [];
        if ($loadItems) {
            $relations[] = 'items';
        }

        $order = OrderModel::with($relations)->where('id', $id)->first();

        // throw exception if order not found
        if (!$order) {
            throw new OrderNotFoundException("Get order failed. because order id #$id not found.");
        }

        return $order;
    }

    /**
     * Create new order
     *
     * @param string $namespace
     * @param string $session
     * @param Collection $collection
     * @return Model
     * @throws InvalidClassException|EmptyCartException|Exception
     */
    public function create(string $namespace, string $session, Collection $collection): Model
    {

        if (!$collection->count()) {
            throw new EmptyCartException("Create order failed because cart is empty");
        }

        DB::beginTransaction();

        try {
            /**
             * @var OrderModel $order
             */
            $order = OrderModel::query()->create([
                'session' => $this->session,
                'namespace' => $this->namespace,
                'code' => substr(uniqid(), 0, 8),
            ]);

            /**
             * @var Orderable $orderItem
             */
            foreach ($collection as $orderItem) {

                if (!$orderItem instanceof Orderable) {
                    throw new InvalidClassException("All items of collection should implements Orderable interface");
                }

                $order->items()->create([
                    'orderable_type' => $orderItem->getOrderableType(),
                    'orderable_id' => $orderItem->getOrderableID(),
                    'quantity' => $orderItem->quantity,
                    'amount' => $orderItem->getAmount(),
                    'discount' => $orderItem->getDiscount()
                ]);
            }
        } catch (InvalidClassException $classException) {
            DB::rollBack();
            throw new InvalidClassException($classException->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }


        DB::commit();
        return $order;
    }
}