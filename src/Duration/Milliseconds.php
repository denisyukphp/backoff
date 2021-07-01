<?php

namespace Orangesoft\BackOff\Duration;

final class Milliseconds extends AbstractDuration
{
    public function __construct(float $milliseconds)
    {
        parent::__construct($milliseconds * 1000 * 1000);
    }
}
