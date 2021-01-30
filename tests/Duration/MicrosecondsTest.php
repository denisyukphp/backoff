<?php

namespace Orangesoft\Backoff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Microseconds;

class MicrosecondsTest extends TestCase
{
    public function testMicroseconds(): void
    {
        $microseconds = new Microseconds(1 * 1000 * 1000);

        $this->assertEquals(1 * 1000 * 1000 * 1000, $microseconds->toNanoseconds());
        $this->assertEquals(1 * 1000 * 1000, $microseconds->toMicroseconds());
        $this->assertEquals(1 * 1000, $microseconds->toMilliseconds());
        $this->assertEquals(1, $microseconds->toSeconds());
    }
}
