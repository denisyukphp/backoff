<?php

namespace Orangesoft\Backoff;

use Orangesoft\Backoff\Duration\DurationInterface;

interface BackoffInterface
{
    public function getSleepTime(int $attempt): DurationInterface;
}
