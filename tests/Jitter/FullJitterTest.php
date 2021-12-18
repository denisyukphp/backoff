<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Jitter;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Jitter\FullJitter;
use PHPUnit\Framework\TestCase;

class FullJitterTest extends TestCase
{
    public function testJitter(): void
    {
        $fullJitter = new FullJitter();

        $duration = $fullJitter->jitter(new Nanoseconds(1_000));

        $this->assertGreaterThanOrEqual(0, $duration->asNanoseconds());
        $this->assertLessThanOrEqual(1_000, $duration->asNanoseconds());
    }
}
