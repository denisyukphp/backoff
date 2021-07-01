<?php

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class DecorrelationJitterStrategy implements StrategyInterface
{
    /**
     * @var int
     */
    private $multiplier;
    /**
     * @var float|null
     */
    private $previous;

    public function __construct(int $multiplier = 3)
    {
        $this->multiplier = $multiplier;
    }

    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        $base = $duration->asNanoseconds();

        if (0 === $attempt || null === $this->previous) {
            $this->previous = $base;
        }

        $this->previous = mt_rand($base, $this->previous * $this->multiplier);

        return new Nanoseconds($this->previous);
    }
}
