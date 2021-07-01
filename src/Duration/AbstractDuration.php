<?php

namespace Orangesoft\BackOff\Duration;

abstract class AbstractDuration implements DurationInterface
{
    /**
     * @var float
     */
    private $nanoseconds;

    protected function __construct(float $nanoseconds)
    {
        $this->nanoseconds = $nanoseconds;
    }

    public function asNanoseconds(): float
    {
        return $this->nanoseconds;
    }

    public function asMicroseconds(): float
    {
        return $this->nanoseconds / 1000;
    }

    public function asMilliseconds(): float
    {
        return $this->nanoseconds / 1000 / 1000;
    }

    public function asSeconds(): float
    {
        return $this->nanoseconds / 1000 / 1000 / 1000;
    }
}
