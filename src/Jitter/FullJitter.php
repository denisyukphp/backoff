<?php

namespace Orangesoft\Backoff\Jitter;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Nanoseconds;

class FullJitter implements JitterInterface
{
    public function getJitterTime(DurationInterface $sleepTime): DurationInterface
    {
        $nanoseconds = mt_rand(0, $sleepTime->toNanoseconds());

        return new Nanoseconds($nanoseconds);
    }
}
