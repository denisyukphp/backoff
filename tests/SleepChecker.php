<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Sleeper\SleeperInterface;

class SleepChecker implements SleeperInterface
{
    private ?DurationInterface $duration = null;

    public function sleep(DurationInterface $duration): void
    {
        $this->duration = $duration;
    }

    public function getDuration(): ?DurationInterface
    {
        return $this->duration;
    }
}
