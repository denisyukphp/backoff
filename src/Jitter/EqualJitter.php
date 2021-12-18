<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class EqualJitter implements JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface
    {
        $nanoseconds = (int) $duration->asNanoseconds();

        return new Nanoseconds($nanoseconds / 2 + mt_rand(0, $nanoseconds / 2));
    }
}
