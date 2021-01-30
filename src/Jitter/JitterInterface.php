<?php

namespace Orangesoft\Backoff\Jitter;

use Orangesoft\Backoff\Duration\DurationInterface;

interface JitterInterface
{
    public function getJitterTime(DurationInterface $sleepTime): DurationInterface;
}
