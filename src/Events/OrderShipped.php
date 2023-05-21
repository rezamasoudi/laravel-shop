<?php

namespace Masoudi\Laravel\Shop\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Masoudi\Laravel\Shop\Models\Order;

class OrderShipped
{
    use Dispatchable;

    public function __construct(public Order $order)
    {
    }
}