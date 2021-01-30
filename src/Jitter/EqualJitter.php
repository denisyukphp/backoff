<?php

namespace Orangesoft\Backoff\Jitter;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Nanoseconds;

class EqualJitter implements JitterInterface
{
    public function getJitterTime(DurationInterface $sleepTime): DurationInterface
    {
        $nanoseconds = $sleepTime->toNanoseconds() / 2 + mt_rand(0, $sleepTime->toNanoseconds() / 2);

        return new Nanoseconds($nanoseconds);
    }
}
