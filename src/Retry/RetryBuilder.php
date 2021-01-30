<?php

namespace Orangesoft\Backoff\Retry;

use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifierInterface;
use Orangesoft\Backoff\Sleeper\DummySleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class RetryBuilder
{
    /**
     * @var int
     */
    private $maxAttempts;
    /**
     * @var ExceptionClassifierInterface
     */
    private $exceptionClassifier;
    /**
     * @var SleeperInterface
     */
    private $sleeper;

    public function __construct()
    {
        $this->maxAttempts = 5;
        $this->exceptionClassifier = new ExceptionClassifier();
        $this->sleeper = new DummySleeper();
    }

    public function setMaxAttempts(int $maxAttempts): self
    {
        $this->maxAttempts = $maxAttempts;

        return $this;
    }

    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }

    public function setExceptionClassifier(ExceptionClassifierInterface $exceptionClassifier): self
    {
        $this->exceptionClassifier = $exceptionClassifier;

        return $this;
    }

    public function getExceptionClassifier(): ExceptionClassifierInterface
    {
        return $this->exceptionClassifier;
    }

    public function setSleeper(SleeperInterface $sleeper): self
    {
        $this->sleeper = $sleeper;

        return $this;
    }

    public function getSleeper(): SleeperInterface
    {
        return $this->sleeper;
    }

    public function build(): RetryInterface
    {
        return new Retry($this);
    }
}
