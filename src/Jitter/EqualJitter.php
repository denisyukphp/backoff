<?php

namespace Orangesoft\Backoff\Jitter;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Nanoseconds;

class EqualJitter implements JitterInterface
{
    public function getJitterTime(DurationInterface $nextTime): DurationInterface
    {
        $nanoseconds = $nextTime->toNanoseconds() / 2 + mt_rand(0, $nextTime->toNanoseconds() / 2);

        return new Nanoseconds($nanoseconds);
    }
}
