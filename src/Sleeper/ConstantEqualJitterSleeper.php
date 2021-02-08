<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\ConstantEqualJitterBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class ConstantEqualJitterSleeper extends AbstractSleeper
{
    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface $capTime
     * @param float|int $maxAttempts
     *
     * @return SleeperInterface
     */
    public function getSleeper(DurationInterface $baseTime, DurationInterface $capTime, float $maxAttempts): SleeperInterface
    {
        $backoff = new ConstantEqualJitterBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }
}
