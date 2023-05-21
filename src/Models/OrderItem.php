<?php

namespace Masoudi\Laravel\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "orderable_type",
        "orderable_id",
        "quantity",
        "amount",
        "discount"
    ];

    protected $with = ['orderable'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderable(): MorphTo
    {
        return $this->morphTo('orderable', 'orderable_type', 'orderable_id');
    }
}