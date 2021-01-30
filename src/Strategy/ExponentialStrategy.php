<?php

namespace Orangesoft\Backoff\Strategy;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Nanoseconds;

class ExponentialStrategy implements StrategyInterface
{
    /**
     * @var DurationInterface
     */
    protected $baseTime;

    public function __construct(DurationInterface $baseTime)
    {
        $this->baseTime = $baseTime;
    }

    public function getWaitTime(int $attempt): DurationInterface
    {
        $nanoseconds = $this->baseTime->toNanoseconds() * pow(2, $attempt);

        return new Nanoseconds($nanoseconds);
    }
}
