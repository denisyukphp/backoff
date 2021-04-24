<?php

namespace Orangesoft\Backoff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Strategy\ConstantStrategy;

class ConstantStrategyTest extends TestCase
{
    public function testWaitTime(): void
    {
        $strategy = new ConstantStrategy(new Milliseconds(1000));

        $waitTime = $strategy->getWaitTime(4);

        $this->assertEquals(1000, $waitTime->asMilliseconds());
    }
}
