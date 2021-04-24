<?php

namespace Orangesoft\Backoff\Strategy;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Nanoseconds;

class DecorrelationJitterStrategy implements StrategyInterface
{
    /**
     * @var DurationInterface
     */
    protected $baseTime;
    /**
     * @var DurationInterface
     */
    protected $waitTime;

    public function __construct(DurationInterface $baseTime)
    {
        $this->baseTime = $this->waitTime = $baseTime;
    }

    public function getWaitTime(int $attempt): DurationInterface
    {
        $nanoseconds = mt_rand($this->baseTime->asNanoseconds(), $this->waitTime->asNanoseconds() * 3);

        $this->waitTime = new Nanoseconds($nanoseconds);

        return $this->waitTime;
    }
}
