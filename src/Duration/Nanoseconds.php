<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

final class Nanoseconds extends AbstractDuration
{
    public function __construct(int|float $nanoseconds)
    {
        parent::__construct($nanoseconds);
    }
}
