<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\ExponentialBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class ExponentialSleeper extends AbstractSleeper
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
        $backoff = new ExponentialBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }
}
