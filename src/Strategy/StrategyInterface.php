<?php

namespace Orangesoft\Backoff\Strategy;

use Orangesoft\Backoff\Duration\DurationInterface;

interface StrategyInterface
{
    public function getWaitTime(int $attempt): DurationInterface;
}
