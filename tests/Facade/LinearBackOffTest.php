<?php

namespace Orangesoft\BackOff\Tests\Facade;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Facade\LinearBackOff;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;

class LinearBackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $maxAttempts = 0;
        $baseTimeMs = 0;
        $capTimeMs = 0;
        $jitter = new DummyJitter();
        $sleeper = new Sleeper();

        $backOff = new LinearBackOff($maxAttempts, $baseTimeMs, $capTimeMs, $jitter, $sleeper);

        $this->expectException(\RuntimeException::class);

        $backOff->backOff(0, new \RuntimeException());
    }
}
