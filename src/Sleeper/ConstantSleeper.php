<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\ConstantBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class ConstantSleeper extends AbstractSleeper
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
        $backoff = new ConstantBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }
}
