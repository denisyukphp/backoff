<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Duration\Duration;

interface BackOffInterface
{
    public function backOff(int $attempt, Duration $baseTime, Duration $capTime): void;
}
