<?php

namespace Orangesoft\Backoff\Factory;

use Orangesoft\Backoff\Backoff;
use Orangesoft\Backoff\BackoffInterface;
use Orangesoft\Backoff\Strategy\LinearStrategy;
use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Jitter\EqualJitter;
use Orangesoft\Backoff\Duration\DurationInterface;

class LinearEqualJitterBackoff extends AbstractBackoff
{
    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface $capTime
     * @param float|int $maxAttempts
     *
     * @return BackoffInterface
     */
    protected function getBackoff(DurationInterface $baseTime, DurationInterface $capTime, float $maxAttempts): BackoffInterface
    {
        return new Backoff(
            new LinearStrategy($baseTime),
            (new ConfigBuilder())
                ->setCapTime($capTime)
                ->setMaxAttempts($maxAttempts)
                ->setJitter(new EqualJitter())
                ->build()
        );
    }
}
