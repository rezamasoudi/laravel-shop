<?php

namespace Masoudi\Laravel\Shop\Listeners;

use Masoudi\Laravel\Shop\Events\OrderCancelled;

class CancelOrder
{
    public function handle(OrderCancelled $event): void
    {
        $event->order->update(['status' => 'cancelled']);
    }
}