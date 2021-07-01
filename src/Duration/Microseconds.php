<?php

namespace Orangesoft\BackOff\Duration;

final class Microseconds extends AbstractDuration
{
    public function __construct(float $microseconds)
    {
        parent::__construct($microseconds * 1000);
    }
}
