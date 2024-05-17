<?php

declare(strict_types=1);

namespace Duration;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Duration\Seconds;
use PHPUnit\Framework\TestCase;

final class DurationTest extends TestCase
{
    /**
     * @dataProvider getDurationData
     */
    public function testDuration(Duration $duration): void
    {
        $this->assertEquals(1, $duration->asSeconds());
        $this->assertEquals(1_000, $duration->asMilliseconds());
        $this->assertEquals(1_000_000, $duration->asMicroseconds());
        $this->assertEquals(1_000_000_000, $duration->asNanoseconds());
    }

    public function getDurationData(): array
    {
        return [
            [new Seconds(1)],
            [new Milliseconds(1_000)],
            [new Microseconds(1_000_000)],
            [new Nanoseconds(1_000_000_000)],
        ];
    }
}
