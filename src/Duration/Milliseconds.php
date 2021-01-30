<?php

namespace Orangesoft\Backoff\Duration;

class Milliseconds extends Duration
{
    public function __construct(float $milliseconds)
    {
        parent::__construct($milliseconds * 1000 * 1000);
    }
}
