<?php

namespace Masoudi\Laravel\Shop\Contracts;

interface Orderable
{
    /**
     * orderable amount
     *
     * @return float
     */
    function getAmount(): float;

    /**
     * Discount of orderable in range 0-100
     *
     * @return int
     */
    function getDiscount(): int;

    /**
     * Get orderable index id
     *
     * @return int
     */
    function getOrderableID(): int;

    /**
     * Get orderable type
     *
     * @return string
     */
    function getOrderableType(): string;

}