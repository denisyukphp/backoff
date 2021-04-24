<?php

namespace Orangesoft\Backoff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Seconds;

class SecondsTest extends TestCase
{
    public function testSeconds(): void
    {
        $seconds = new Seconds(1);

        $this->assertEquals(1 * 1000 * 1000 * 1000, $seconds->asNanoseconds());
        $this->assertEquals(1 * 1000 * 1000, $seconds->asMicroseconds());
        $this->assertEquals(1 * 1000, $seconds->asMilliseconds());
        $this->assertEquals(1, $seconds->asSeconds());
    }
}
