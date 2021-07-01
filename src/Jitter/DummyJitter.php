<?php

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;

class DummyJitter implements JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface
    {
        return $duration;
    }
}
