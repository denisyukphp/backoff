<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\BackOffInterface;

class AttemptsCounterBackOff implements BackOffInterface
{
    private int $lastAttempt = 0;

    public function __construct(
        private int $maxAttempts,
    ) {
    }

    public function backOff(int $attempt, \Throwable $throwable): void
    {
        if ($this->maxAttempts === $this->lastAttempt = $attempt) {
            throw $throwable;
        }
    }

    public function getLastAttempt(): int
    {
        return $this->lastAttempt;
    }
}
