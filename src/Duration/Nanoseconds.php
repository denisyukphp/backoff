<?php

namespace Orangesoft\BackOff\Duration;

final class Nanoseconds extends AbstractDuration
{
    public function __construct(float $nanoseconds)
    {
        parent::__construct($nanoseconds);
    }
}
