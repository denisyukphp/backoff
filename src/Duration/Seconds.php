<?php

namespace Orangesoft\BackOff\Duration;

final class Seconds extends AbstractDuration
{
    public function __construct(float $seconds)
    {
        parent::__construct($seconds * 1000 * 1000 * 1000);
    }
}
