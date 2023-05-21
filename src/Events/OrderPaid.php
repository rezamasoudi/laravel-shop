<?php

namespace Masoudi\Laravel\Shop\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Masoudi\Laravel\Shop\Models\Order;

class OrderPaid
{
    use Dispatchable;

    public function __construct(public Order $order)
    {
    }

}