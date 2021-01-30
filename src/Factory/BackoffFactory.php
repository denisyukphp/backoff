<?php

namespace Orangesoft\Backoff\Factory;

use Orangesoft\Backoff\BackoffInterface;
use Orangesoft\Backoff\Duration\DurationInterface;

class BackoffFactory
{
    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getLinearBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new LinearBackoff($baseTime, $capTime, $maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getLinearFullJitterBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new LinearFullJitterBackoff($baseTime, $capTime, $maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getLinearEqualJitterBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new LinearEqualJitterBackoff($baseTime, $capTime, $maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getExponentialBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new ExponentialBackoff($baseTime, $capTime, $maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getExponentialFullJitterBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new ExponentialFullJitterBackoff($baseTime, $capTime, $maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getExponentialEqualJitterBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new ExponentialEqualJitterBackoff($baseTime, $capTime, $maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     *
     * @return BackoffInterface
     */
    public function getDecorrelationJitterBackoff(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ): BackoffInterface {
        return new DecorrelationJitterBackoff($baseTime, $capTime, $maxAttempts);
    }
}
