<?php

namespace Orangesoft\Backoff\Sleeper;

class DummySleeper implements SleeperInterface
{
    public function sleep(int $attempt): void
    {
    }
}
