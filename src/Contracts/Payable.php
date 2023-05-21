<?php

namespace Masoudi\Laravel\Cart\Contracts;

interface Payable
{
    /**
     * Payable amount
     *
     * @return float
     */
    function getAmount(): float;

    /**
     * Discount of payable in range 0-100
     *
     * @return int
     */
    function getDiscount(): int;

    /**
     * Get payable index id
     *
     * @return int
     */
    function getPayableID(): int;

}