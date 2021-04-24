<?php

namespace Orangesoft\Backoff\Duration;

interface DurationInterface
{
    public function asNanoseconds(): float;

    public function asMicroseconds(): float;

    public function asMilliseconds(): float;

    public function asSeconds(): float;
}
