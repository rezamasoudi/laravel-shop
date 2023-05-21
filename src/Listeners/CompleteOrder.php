<?php

namespace Masoudi\Laravel\Shop\Listeners;

use Masoudi\Laravel\Shop\Events\OrderCompleted;

class CompleteOrder
{
    public function handle(OrderCompleted $event): void
    {
        $event->order->update(['status' => 'completed']);
    }
}