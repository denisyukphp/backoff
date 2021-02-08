<?php

namespace Orangesoft\Backoff\Factory;

use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\BackoffInterface;

abstract class AbstractBackoff implements BackoffInterface
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
     * @var BackoffInterface
     */
    private $backoff;

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

        $this->backoff = $this->getBackoff($this->baseTime, $this->capTime, $this->maxAttempts);
    }

    /**
     * @param DurationInterface $baseTime
     * @param DurationInterface $capTime
     * @param float|int $maxAttempts
     *
     * @return BackoffInterface
     */
    abstract protected function getBackoff(DurationInterface $baseTime, DurationInterface $capTime, float $maxAttempts): BackoffInterface;

    public function generate(int $attempt): DurationInterface
    {
        return $this->backoff->generate($attempt);
    }

    public function __clone()
    {
        $this->backoff = $this->getBackoff($this->baseTime, $this->capTime, $this->maxAttempts);
    }
}
