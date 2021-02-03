<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\DecorrelationJitterBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class DecorrelationJitterSleeper extends AbstractSleeper
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
        $backoff = new DecorrelationJitterBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }
}
