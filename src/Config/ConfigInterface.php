<?php

namespace Orangesoft\Backoff\Config;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Jitter\JitterInterface;

interface ConfigInterface
{
    public function getCapTime(): DurationInterface;

    /**
     * @return float|int
     */
    public function getMaxAttempts(): float;

    public function isJitterEnabled(): bool;

    public function getJitter(): JitterInterface;
}
