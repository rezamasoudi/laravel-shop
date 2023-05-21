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
        return $this->getAttribute($this->primaryKey);
    }

    /**
     * Get class name
     *
     * @return string
     */
    function getOrderableType(): string
    {
        return $this::class;
    }
}