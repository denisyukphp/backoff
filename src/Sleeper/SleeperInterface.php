<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Sleeper;

use Orangesoft\BackOff\Duration\DurationInterface;

interface SleeperInterface
{
    public function sleep(DurationInterface $duration): void;
}
