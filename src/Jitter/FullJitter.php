<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class FullJitter implements JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface
    {
        return new Nanoseconds(mt_rand(0, (int) $duration->asNanoseconds()));
    }
}
