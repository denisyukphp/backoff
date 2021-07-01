<?php

namespace Orangesoft\BackOff\Tests\Facade;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Facade\ExponentialBackOff;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;

class ExponentialBackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $maxAttempts = 0;
        $baseTimeMs = 0;
        $capTimeMs = 0;
        $multiplier = 0;
        $jitter = new DummyJitter();
        $sleeper = new Sleeper();

        $backOff = new ExponentialBackOff($maxAttempts, $baseTimeMs, $capTimeMs, $multiplier, $jitter, $sleeper);

        $this->assertInstanceOf(BackOffInterface::class, $backOff);

        $this->expectException(\RuntimeException::class);

        $backOff->backOff(0, new \RuntimeException());
    }
}
