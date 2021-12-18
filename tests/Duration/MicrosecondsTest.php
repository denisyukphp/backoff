<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Duration;

use Orangesoft\BackOff\Duration\Microseconds;
use PHPUnit\Framework\TestCase;

class MicrosecondsTest extends TestCase
{
    public function testMicroseconds(): void
    {
        $microseconds = new Microseconds(1_000_000);

        $this->assertEquals(1_000_000_000, $microseconds->asNanoseconds());
        $this->assertEquals(1_000_000, $microseconds->asMicroseconds());
        $this->assertEquals(1_000, $microseconds->asMilliseconds());
        $this->assertEquals(1, $microseconds->asSeconds());
    }
}
