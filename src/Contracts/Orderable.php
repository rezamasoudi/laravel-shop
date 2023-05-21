<?php

namespace Masoudi\Laravel\Shop\Contracts;

interface Orderable
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
    function getOrderableID(): int;

}