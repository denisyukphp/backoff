<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Sleeper;

use Orangesoft\BackOff\Duration\DurationInterface;

final class Sleeper implements SleeperInterface
{
    public function sleep(DurationInterface $duration): void
    {
        $seconds = (int) $duration->asSeconds();
        $nanoseconds = (int) $duration->asNanoseconds() - $seconds * 1_000_000_000;

        time_nanosleep($seconds, $nanoseconds);
    }
}
