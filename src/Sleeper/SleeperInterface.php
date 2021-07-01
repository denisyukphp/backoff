<?php

namespace Orangesoft\BackOff\Sleeper;

use Orangesoft\BackOff\Duration\DurationInterface;

interface SleeperInterface
{
    public function sleep(DurationInterface $duration): void;
}
