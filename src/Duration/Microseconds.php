<?php

namespace Orangesoft\Backoff\Duration;

class Microseconds extends Duration
{
    public function __construct(float $microseconds)
    {
        parent::__construct($microseconds * 1000);
    }
}
