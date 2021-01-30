<?php

namespace Orangesoft\Backoff\Sleeper;

interface SleeperInterface
{
    public function sleep(int $attempt): void;
}
