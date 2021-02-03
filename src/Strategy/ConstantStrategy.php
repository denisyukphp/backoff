<?php

namespace Orangesoft\Backoff\Strategy;

use Orangesoft\Backoff\Duration\DurationInterface;

class ConstantStrategy implements StrategyInterface
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
        return $this->baseTime;
    }
}
