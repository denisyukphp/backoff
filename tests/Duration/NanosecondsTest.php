<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Duration;

use Orangesoft\BackOff\Duration\Nanoseconds;
use PHPUnit\Framework\TestCase;

class NanosecondsTest extends TestCase
{
    public function testNanoseconds(): void
    {
        $nanoseconds = new Nanoseconds(1_000_000_000);

        $this->assertEquals(1_000_000_000, $nanoseconds->asNanoseconds());
        $this->assertEquals(1_000_000, $nanoseconds->asMicroseconds());
        $this->assertEquals(1_000, $nanoseconds->asMilliseconds());
        $this->assertEquals(1, $nanoseconds->asSeconds());
    }
}
