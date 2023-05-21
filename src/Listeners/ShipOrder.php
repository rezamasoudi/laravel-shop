<?php

namespace Masoudi\Laravel\Shop\Listeners;

use Masoudi\Laravel\Shop\Events\OrderShipped;

class ShipOrder
{
    public function handle(OrderShipped $event): void
    {
        $event->order->update(['status' => 'delivering']);
    }
}