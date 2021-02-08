<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Duration\DurationInterface;

abstract class AbstractSleeper implements SleeperInterface
{
    /**
     * @var DurationInterface
     */
    private $baseTime;
    /**
     * @var DurationInterface
     */
    private $capTime;
    /**
     * @var float|int
     */
    private $maxAttempts;
    /**
     * @var SleeperInterface
     */
    private $sleeper;

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface|null $capTime
     * @param float|int|null $maxAttempts
     */
    public function __construct(
        DurationInterface $baseTime,
        ?DurationInterface $capTime = null,
        ?float $maxAttempts = null
    ) {
        $this->baseTime = $baseTime;
        $this->capTime = $capTime ?? ConfigBuilder::getDefaultCapTime();
        $this->maxAttempts = $maxAttempts ?? ConfigBuilder::getDefaultMaxAttempts();

        $this->sleeper = $this->getSleeper($this->baseTime, $this->capTime, $this->maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface $capTime
     * @param float|int $maxAttempts
     *
     * @return SleeperInterface
     */
    abstract protected function getSleeper(DurationInterface $baseTime, DurationInterface $capTime, float $maxAttempts): SleeperInterface;

    public function sleep(int $attempt): void
    {
        $this->sleeper->sleep($attempt);
    }

    public function __clone()
    {
        $this->sleeper = $this->getSleeper($this->baseTime, $this->capTime, $this->maxAttempts);
    }
}
