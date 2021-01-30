<?php

namespace Orangesoft\Backoff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Nanoseconds;

class NanosecondsTest extends TestCase
{
    public function testNanoseconds(): void
    {
        $nanoseconds = new Nanoseconds(1 * 1000 * 1000 * 1000);

        $this->assertEquals(1 * 1000 * 1000 * 1000, $nanoseconds->toNanoseconds());
        $this->assertEquals(1 * 1000 * 1000, $nanoseconds->toMicroseconds());
        $this->assertEquals(1 * 1000, $nanoseconds->toMilliseconds());
        $this->assertEquals(1, $nanoseconds->toSeconds());
    }
}
