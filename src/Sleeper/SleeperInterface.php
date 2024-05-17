<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Sleeper;

use Orangesoft\BackOff\Duration\Duration;

interface SleeperInterface
{
    public function sleep(Duration $sleepTime): void;
}
