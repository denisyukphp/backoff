<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\LinearBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class LinearSleeper extends AbstractSleeper
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
        $backoff = new LinearBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }
}
