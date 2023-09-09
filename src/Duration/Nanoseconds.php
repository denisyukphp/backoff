<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

final class Nanoseconds extends Duration
{
    public function __construct(float $nanoseconds)
    {
        parent::__construct($nanoseconds);
    }
}
