<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Jitter;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;
use PHPUnit\Framework\TestCase;

class EqualJitterTest extends TestCase
{
    public function testJitter(): void
    {
        $equalJitter = new EqualJitter();

        $duration = $equalJitter->jitter(new Nanoseconds(1_000));

        $this->assertGreaterThanOrEqual(500, $duration->asNanoseconds());
        $this->assertLessThanOrEqual(1_000, $duration->asNanoseconds());
    }
}
