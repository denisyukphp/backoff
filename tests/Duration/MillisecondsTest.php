<?php

namespace Orangesoft\Backoff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;

class MillisecondsTest extends TestCase
{
    public function testMilliseconds(): void
    {
        $milliseconds = new Milliseconds(1 * 1000);

        $this->assertEquals(1 * 1000 * 1000 * 1000, $milliseconds->toNanoseconds());
        $this->assertEquals(1 * 1000 * 1000, $milliseconds->toMicroseconds());
        $this->assertEquals(1 * 1000, $milliseconds->toMilliseconds());
        $this->assertEquals(1, $milliseconds->toSeconds());
    }
}
