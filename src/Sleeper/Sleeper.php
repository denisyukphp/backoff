<?php

namespace Orangesoft\Backoff\Sleeper;

use Orangesoft\Backoff\BackoffInterface;

class Sleeper implements SleeperInterface
{
    /**
     * @var BackoffInterface
     */
    private $backoff;

    public function __construct(BackoffInterface $backoff)
    {
        $this->backoff = $backoff;
    }

    public function sleep(int $attempt): void
    {
        $sleepTime = $this->backoff->getSleepTime($attempt);

        $microseconds = (int) $sleepTime->toMicroseconds();

        usleep($microseconds);
    }
}
