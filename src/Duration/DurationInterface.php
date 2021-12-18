<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

interface DurationInterface
{
    public function asNanoseconds(): float;

    public function asMicroseconds(): float;

    public function asMilliseconds(): float;

    public function asSeconds(): float;
}
