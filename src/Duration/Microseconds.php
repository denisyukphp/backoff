<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

final class Microseconds extends Duration
{
    public function __construct(float $microseconds)
    {
        parent::__construct($microseconds * 1_000);
    }
}
