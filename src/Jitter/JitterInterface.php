<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

interface JitterInterface
{
    public function jitter(float $duration): float;
}
