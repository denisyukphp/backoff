<?php

namespace Orangesoft\Backoff\Duration;

class Nanoseconds extends Duration
{
    public function __construct(float $nanoseconds)
    {
        parent::__construct($nanoseconds);
    }
}
