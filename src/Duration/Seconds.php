<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

final class Seconds extends Duration
{
    public function __construct(float $seconds)
    {
        parent::__construct($seconds * 1_000_000_000);
    }
}
