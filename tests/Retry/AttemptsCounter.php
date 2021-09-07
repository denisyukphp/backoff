<?php

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\BackOffInterface;

class AttemptsCounter implements BackOffInterface
{
    /**
     * @var int
     */
    private $lastAttempt;
    /**
     * @var int
     */
    private $maxAttempts;

    public function __construct(int $maxAttempts)
    {
        $this->lastAttempt = 0;
        $this->maxAttempts = $maxAttempts;
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
