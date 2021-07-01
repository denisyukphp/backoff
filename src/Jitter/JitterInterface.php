<?php

namespace Orangesoft\BackOff\Jitter;

use Orangesoft\BackOff\Duration\DurationInterface;

interface JitterInterface
{
    public function jitter(DurationInterface $duration): DurationInterface;
}
