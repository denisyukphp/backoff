<?php

namespace Orangesoft\Backoff\Sleeper;

interface BackoffSleeperInterface
{
    public function sleep(int $attempt): void;
}
