<?php

namespace Masoudi\Laravel\Cart\Contracts;

interface Payable
{
    /**
     * Payable amount
     *
     * @return float
     */
    function amount(): float;

    /**
     * Discount of payable in range 0-100
     *
     * @return int
     */
    function discount(): int;

    /**
     * Get payable index id
     *
     * @return int
     */
    function getUID(): int;

}