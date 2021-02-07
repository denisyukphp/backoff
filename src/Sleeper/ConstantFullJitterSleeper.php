<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Factory\ConstantFullJitterBackoff;
use Orangesoft\Backoff\Duration\DurationInterface;

class ConstantFullJitterSleeper extends AbstractSleeper
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
        $backoff = new ConstantFullJitterBackoff($baseTime, $capTime, $maxAttempts);

        return new Sleeper($backoff);
    }

    public function sleep(int $attempt = 0): void
    {
        parent::sleep($attempt);
    }
}
