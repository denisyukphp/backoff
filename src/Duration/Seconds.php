<?php

namespace Orangesoft\Backoff\Duration;

class Seconds extends Duration
{
    public function __construct(float $seconds)
    {
        parent::__construct($seconds * 1000 * 1000 * 1000);
    }
}
