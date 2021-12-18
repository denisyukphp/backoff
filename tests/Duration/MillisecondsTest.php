<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Duration;

use Orangesoft\BackOff\Duration\Milliseconds;
use PHPUnit\Framework\TestCase;

class MillisecondsTest extends TestCase
{
    public function testMilliseconds(): void
    {
        $milliseconds = new Milliseconds(1_000);

        $this->assertEquals(1_000_000_000, $milliseconds->asNanoseconds());
        $this->assertEquals(1_000_000, $milliseconds->asMicroseconds());
        $this->assertEquals(1_000, $milliseconds->asMilliseconds());
        $this->assertEquals(1, $milliseconds->asSeconds());
    }
}
