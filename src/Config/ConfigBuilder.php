<?php

namespace Orangesoft\Backoff\Config;

use Orangesoft\Backoff\Duration\Seconds;
use Orangesoft\Backoff\Duration\DurationInterface;
use Orangesoft\Backoff\Jitter\JitterInterface;
use Orangesoft\Backoff\Jitter\EqualJitter;

class ConfigBuilder
{
    /**
     * @var DurationInterface
     */
    protected $capTime;
    /**
     * @var float|int
     */
    protected $maxAttempts;
    /**
     * @var bool
     */
    protected $useJitter;
    /**
     * @var JitterInterface
     */
    protected $jitter;

    public function __construct()
    {
        $this->capTime = self::getDefaultCapTime();
        $this->maxAttempts = self::getDefaultMaxAttempts();
        $this->useJitter = self::getDefaultUseJitter();
        $this->jitter = self::getDefaultJitter();
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

    public static function getDefaultCapTime(): DurationInterface
    {
        return new Seconds(60);
    }

    /**
     * @param float|int $maxAttempts
     *
     * @return self
     */
    public function setMaxAttempts(float $maxAttempts): self
    {
        $this->maxAttempts = $maxAttempts;

        return $this;
    }

    /**
     * @return float|int
     */
    public function getMaxAttempts(): float
    {
        return $this->maxAttempts;
    }

    public static function getDefaultMaxAttempts(): float
    {
        return INF;
    }

    public function enableJitter(): self
    {
        $this->useJitter = true;

        return $this;
    }

    public function isJitterEnabled(): bool
    {
        return $this->useJitter;
    }

    public static function getDefaultUseJitter(): bool
    {
        return false;
    }

    public function setJitter(JitterInterface $jitter): self
    {
        $this->enableJitter();

        $this->jitter = $jitter;

        return $this;
    }

    public static function getDefaultJitter(): JitterInterface
    {
        return new EqualJitter();
    }

    public function getJitter(): JitterInterface
    {
        return $this->jitter;
    }

    public function build(): ConfigInterface
    {
        return new Config($this);
    }
}
