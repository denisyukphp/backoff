<?php

namespace Orangesoft\BackOff\Tests\Facade;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Facade\ConstantBackOff;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;

class ConstantBackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $maxAttempts = 0;
        $baseTimeMs = 0;
        $capTimeMs = 0;
        $jitter = new DummyJitter();
        $sleeper = new Sleeper();

        $backOff = new ConstantBackOff($maxAttempts, $baseTimeMs, $capTimeMs, $jitter, $sleeper);

        $this->assertInstanceOf(BackOffInterface::class, $backOff);

        $this->expectException(\RuntimeException::class);

        $backOff->backOff(0, new \RuntimeException());
    }
}
