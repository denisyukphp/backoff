<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

final class NullBackOff implements BackOffInterface
{
    public function __construct(
        private int|float $maxAttempts = 3,
    ) {
    }

    public function backOff(int $attempt, \Throwable $throwable): void
    {
        if ($attempt > $this->maxAttempts) {
            throw $throwable;
        }
    }
}
