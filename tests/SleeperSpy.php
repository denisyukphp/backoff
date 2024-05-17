<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Sleeper\SleeperInterface;

final class SleeperSpy implements SleeperInterface
{
    private ?Duration $sleepTime = null;

    public function sleep(Duration $sleepTime): void
    {
        $this->sleepTime = $sleepTime;
    }

    public function getSleepTime(): ?Duration
    {
        return $this->sleepTime;
    }
}
