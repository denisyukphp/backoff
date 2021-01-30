<?php

namespace Orangesoft\Backoff\Duration;

abstract class Duration implements DurationInterface
{
    /**
     * @var float
     */
    protected $nanoseconds;

    protected function __construct(float $nanoseconds)
    {
        $this->nanoseconds = $nanoseconds;
    }

    public function toNanoseconds(): float
    {
        return $this->nanoseconds;
    }

    public function toMicroseconds(): float
    {
        return $this->nanoseconds / 1000;
    }

    public function toMilliseconds(): float
    {
        return $this->nanoseconds / 1000 / 1000;
    }

    public function toSeconds(): float
    {
        return $this->nanoseconds / 1000 / 1000 / 1000;
    }
}
