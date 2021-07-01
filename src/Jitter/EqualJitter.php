<?php

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class EqualJitter implements JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface
    {
        $nanoseconds = $duration->asNanoseconds() / 2 + mt_rand(0, $duration->asNanoseconds() / 2);

        return new Nanoseconds($nanoseconds);
    }
}
