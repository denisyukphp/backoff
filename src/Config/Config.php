<?php

namespace Orangesoft\Backoff\Config;

use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Jitter\JitterInterface;

class Config implements ConfigInterface
{
    /**
     * @var ConfigBuilder
     */
    private $configBuilder;

    public function __construct(ConfigBuilder $configBuilder)
    {
        $this->configBuilder = $configBuilder;
    }

    public function getCapTime(): DurationInterface
    {
        return $this->configBuilder->getCapTime();
    }

    /**
     * @return float|int
     */
    public function getMaxAttempts(): float
    {
        return $this->configBuilder->getMaxAttempts();
    }

    public function isJitterEnabled(): bool
    {
        return $this->configBuilder->isJitterEnabled();
    }

    public function getJitter(): JitterInterface
    {
        return $this->configBuilder->getJitter();
    }
}
