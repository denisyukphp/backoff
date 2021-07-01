<?php

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class FullJitter implements JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface
    {
        $nanoseconds = mt_rand(0, $duration->asNanoseconds());

        return new Nanoseconds($nanoseconds);
    }
}
