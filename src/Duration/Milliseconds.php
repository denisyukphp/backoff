<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Duration;

final class Milliseconds extends Duration
{
    public function __construct(float $milliseconds)
    {
        parent::__construct($milliseconds * 1_000_000);
    }
}
