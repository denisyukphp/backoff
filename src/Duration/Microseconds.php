<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

final class Microseconds extends AbstractDuration
{
    public function __construct(int|float $microseconds)
    {
        parent::__construct($microseconds * 1_000);
    }
}
