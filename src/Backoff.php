<?php

namespace Orangesoft\Backoff;

use Orangesoft\Backoff\Strategy\StrategyInterface;
use Orangesoft\Backoff\Config\ConfigInterface;
use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Duration\Comparator;
use Orangesoft\Backoff\Exception\LimitedAttemptsException;

final class Backoff implements BackoffInterface
{
    /**
     * @var StrategyInterface
     */
    private $strategy;
    /**
     * @var ConfigInterface
     */
    private $config;

    public function __construct(StrategyInterface $strategy, ConfigInterface $config)
    {
        $this->strategy = $strategy;
        $this->config = $config;
    }

    /**
     * @param int $attempt
     *
     * @return DurationInterface
     *
     * @throws LimitedAttemptsException
     */
    public function getSleepTime(int $attempt): DurationInterface
    {
        if ($attempt >= $this->config->getMaxAttempts()) {
            throw new LimitedAttemptsException('Attempts have reached the limit');
        }

        $capTime = $this->config->getCapTime();
        $waitTime = $this->strategy->getWaitTime($attempt);

        $comparator = new Comparator($capTime, $waitTime);

        $sleepTime = $comparator->getMin();

        return $this->config->isJitterEnabled() ? $this->config->getJitter()->getJitterTime($sleepTime) : $sleepTime;
    }
}
