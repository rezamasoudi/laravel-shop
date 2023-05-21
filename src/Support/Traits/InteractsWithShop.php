<?php

namespace Masoudi\Laravel\Shop\Support\Traits;

trait InteractsWithShop
{
    /**
     * Get primary key
     *
     * @return int
     */
    function getOrderableID(): int
    {
        $this->getAttribute($this->primaryKey);
    }
}