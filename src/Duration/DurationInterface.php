<?php

namespace Orangesoft\Backoff\Duration;

interface DurationInterface
{
    public function toNanoseconds(): float;

    public function toMicroseconds(): float;

    public function toMilliseconds(): float;

    public function toSeconds(): float;
}
