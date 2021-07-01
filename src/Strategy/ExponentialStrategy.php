<?php

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class ExponentialStrategy implements StrategyInterface
{
    /**
     * @var int
     */
    private $multiplier;

    public function __construct(int $multiplier = 2)
    {
        $this->multiplier = $multiplier;
    }

    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        $nanoseconds = $duration->asNanoseconds() * ($this->multiplier ** $attempt);

        return new Nanoseconds($nanoseconds);
    }
}
