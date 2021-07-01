<?php

namespace Orangesoft\BackOff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Duration\Nanoseconds;

class NanosecondsTest extends TestCase
{
    public function testNanoseconds(): void
    {
        $nanoseconds = new Nanoseconds(1 * 1000 * 1000 * 1000);

        $this->assertEquals(1 * 1000 * 1000 * 1000, $nanoseconds->asNanoseconds());
        $this->assertEquals(1 * 1000 * 1000, $nanoseconds->asMicroseconds());
        $this->assertEquals(1 * 1000, $nanoseconds->asMilliseconds());
        $this->assertEquals(1, $nanoseconds->asSeconds());
    }
}
