<?php

namespace Orangesoft\Backoff\Jitter;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Nanoseconds;

class FullJitter implements JitterInterface
{
    public function getJitterTime(DurationInterface $backoffTime): DurationInterface
    {
        $nanoseconds = mt_rand(0, $backoffTime->asNanoseconds());

        return new Nanoseconds($nanoseconds);
    }
}
