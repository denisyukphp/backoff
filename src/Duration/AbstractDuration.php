<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

abstract class AbstractDuration implements DurationInterface
{
    protected function __construct(
        private int|float $nanoseconds,
    ) {
    }

    public function asNanoseconds(): float
    {
        return (float) $this->nanoseconds;
    }

    public function asMicroseconds(): float
    {
        return $this->nanoseconds / 1_000;
    }

    public function asMilliseconds(): float
    {
        return $this->nanoseconds / 1_000_000;
    }

    public function asSeconds(): float
    {
        return $this->nanoseconds / 1_000_000_000;
    }
}
