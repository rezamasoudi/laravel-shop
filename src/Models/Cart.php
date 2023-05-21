<?php

namespace Masoudi\Laravel\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Cart extends Model
{

    protected $fillable = [
        'orderable_type',
        'orderable_id',
        'session',
        'namespace',
        'quantity',
    ];

    public function orderable(): MorphTo
    {
        return $this->morphTo('orderable', 'orderable_type', 'orderable_id');
    }
}
