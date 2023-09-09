<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

final class NullJitter implements JitterInterface
{
    public function jitter(float $duration): float
    {
        return $duration;
    }
}
