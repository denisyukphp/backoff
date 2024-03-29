<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;

final class NullJitter implements JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface
    {
        return $duration;
    }
}
