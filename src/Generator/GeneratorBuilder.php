<?php

namespace Orangesoft\BackOff\Generator;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\StrategyInterface;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Jitter\DummyJitter;

class GeneratorBuilder
{
    /**
     * @var float
     */
    protected $maxAttempts;
    /**
     * @var DurationInterface
     */
    protected $baseTime;
    /**
     * @var DurationInterface
     */
    protected $capTime;
    /**
     * @var StrategyInterface
     */
    protected $strategy;
    /**
     * @var JitterInterface
     */
    protected $jitter;

    public function __construct()
    {
        $this->maxAttempts = INF;
        $this->baseTime = new Milliseconds(1000);
        $this->capTime = new Milliseconds(60 * 1000);
        $this->strategy = new ExponentialStrategy(2);
        $this->jitter = new DummyJitter();
    }

    public static function create(): self
    {
        return new self();
    }

    public function setMaxAttempts(float $maxAttempts): self
    {
        $this->maxAttempts = $maxAttempts;

        return $this;
    }

    public function getMaxAttempts(): float
    {
        return $this->maxAttempts;
    }

    public function setBaseTime(DurationInterface $baseTime): self
    {
        $this->baseTime = $baseTime;

        return $this;
    }

    public function getBaseTime(): DurationInterface
    {
        return $this->baseTime;
    }

    public function setCapTime(DurationInterface $capTime): self
    {
        $this->capTime = $capTime;

        return $this;
    }

    public function getCapTime(): DurationInterface
    {
        return $this->capTime;
    }

    public function setStrategy(StrategyInterface $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function getStrategy(): StrategyInterface
    {
        return $this->strategy;
    }

    public function setJitter(JitterInterface $jitter): self
    {
        $this->jitter = $jitter;

        return $this;
    }

    public function getJitter(): JitterInterface
    {
        return $this->jitter;
    }

    public function build(): Generator
    {
        return new Generator($this);
    }
}
