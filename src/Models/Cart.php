<?php

namespace Masoudi\Laravel\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Cart extends Model
{

    protected $fillable = [
        'payable_type',
        'payable_id',
        'session',
        'namespace',
        'quantity',
    ];

    public function payable(): MorphTo
    {
        return $this->morphTo('payable', 'payable_type', 'payable_id');
    }
}
