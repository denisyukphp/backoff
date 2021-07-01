<?php

namespace Orangesoft\BackOff\Sleeper;

use Orangesoft\BackOff\Duration\DurationInterface;

final class Sleeper implements SleeperInterface
{
    public function sleep(DurationInterface $duration): void
    {
        $microseconds = $duration->asMicroseconds();

        usleep($microseconds);
    }
}
