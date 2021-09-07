<?php

namespace Orangesoft\BackOff\Tests\Facade;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Facade\DecorrelationJitterBackOff;
use Orangesoft\BackOff\Sleeper\Sleeper;

class DecorrelationJitterBackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $maxAttempts = 0;
        $baseTimeMs = 0;
        $capTimeMs = 0;
        $multiplier = 0;
        $sleeper = new Sleeper();

        $backOff = new DecorrelationJitterBackOff($maxAttempts, $baseTimeMs, $capTimeMs, $multiplier, $sleeper);

        $this->expectException(\RuntimeException::class);

        $backOff->backOff(0, new \RuntimeException());
    }
}
