<?php

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\BackOffInterface;

class BackOffCounter implements BackOffInterface
{
    /**
     * @var int
     */
    private $maxAttempts;
    /**
     * @var int
     */
    private $lastAttempt;

    public function __construct(int $maxAttempts, int $lastAttempt = 0)
    {
        $this->maxAttempts = $maxAttempts;
        $this->lastAttempt = $lastAttempt;
    }

    /**
     * @param int $attempt
     * @param \Throwable $throwable
     *
     * @throws \Throwable
     */
    public function backOff(int $attempt, \Throwable $throwable): void
    {
        $this->lastAttempt = $attempt;

        if ($attempt === $this->maxAttempts) {
            throw $throwable;
        }
    }

    public function getLastAttempt(): int
    {
        return $this->lastAttempt;
    }
}
