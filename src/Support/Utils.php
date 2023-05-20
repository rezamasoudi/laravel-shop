<?php

namespace Masoudi\Laravel\Cart\Support;

class Utils
{
    /**
     * @param float $price
     * @param int $discount
     * @param $quantity
     * @return float
     */
    public static function calculateProductPrice(float $price, int $discount, $quantity): float
    {
        $total = 0.0;
        for ($i = 1; $i <= $quantity; $i++) {
            $total += $price - ($price / 100 * $discount);
        }

        return $total;
    }
}