<?php

namespace Masoudi\Laravel\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}