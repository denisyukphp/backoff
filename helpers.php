<?php

declare(strict_types=1);

if (!function_exists('random_float')) {
    /**
     * @param float $min
     * @param float $max
     * @return float
     * @throws \InvalidArgumentException
     */
    function random_float(float $min, float $max): float
    {
        if ($min > $max) {
            throw new \InvalidArgumentException('Max value must be greater than min.');
        }

        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    };
}
