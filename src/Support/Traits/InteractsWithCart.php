<?php

namespace Masoudi\Laravel\Cart\Support\Traits;

trait InteractsWithCart
{
    /**
     * Get primary key
     *
     * @return int
     */
    function getUID(): int
    {
        $this->getAttribute($this->primaryKey);
    }
}