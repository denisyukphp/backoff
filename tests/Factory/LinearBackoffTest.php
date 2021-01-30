<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\LinearBackoff;

class LinearBackoffTest extends TestCase
{
    public function testLinear(): void
    {
        $backoff = new LinearBackoff(new Milliseconds(1000));

        $sleepTime = $backoff->getSleepTime(4);

        $this->assertEquals(5000, $sleepTime->toMilliseconds());
    }
}
