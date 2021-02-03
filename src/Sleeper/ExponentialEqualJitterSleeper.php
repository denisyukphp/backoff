<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\ExponentialEqualJitterBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class ExponentialEqualJitterSleeper extends AbstractSleeper
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
        $backoff = new ExponentialEqualJitterBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }
}
