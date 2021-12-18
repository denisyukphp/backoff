<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Duration;

use Orangesoft\BackOff\Duration\Seconds;
use PHPUnit\Framework\TestCase;

class SecondsTest extends TestCase
{
    public function testSeconds(): void
    {
        $seconds = new Seconds(1);

        $this->assertEquals(1_000_000_000, $seconds->asNanoseconds());
        $this->assertEquals(1_000_000, $seconds->asMicroseconds());
        $this->assertEquals(1_000, $seconds->asMilliseconds());
        $this->assertEquals(1, $seconds->asSeconds());
    }
}
