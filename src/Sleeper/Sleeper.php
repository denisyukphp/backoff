<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Sleeper;

use Assert\Assertion;
use Orangesoft\BackOff\Duration\Duration;

final class Sleeper implements SleeperInterface
{
    public function sleep(Duration $sleepTime): void
    {
        $time = $sleepTime->asMicroseconds();

        Assertion::greaterOrEqualThan($time, 0); // @codeCoverageIgnore

        $seconds = (int) ($time / 1_000_000);
        $microseconds = $time % 1_000_000;

        if (0 < $seconds) {
            sleep($seconds);
        }

        if (0 < $microseconds) {
            usleep($microseconds);
        }
    }
}
