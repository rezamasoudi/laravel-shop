<?php

namespace Masoudi\Laravel\Shop\Listeners;

use Masoudi\Laravel\Shop\Events\OrderPaid;

class ProcessOrder
{
    public function handle(OrderPaid $event): void
    {
        $event->order->update(['status' => 'processing']);
    }
}