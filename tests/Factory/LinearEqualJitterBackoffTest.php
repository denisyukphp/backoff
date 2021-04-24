<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\LinearEqualJitterBackoff;

class LinearEqualJitterBackoffTest extends TestCase
{
    public function testLinearEqualJitter(): void
    {
        $backoff = new LinearEqualJitterBackoff(new Milliseconds(1000));

        $backoffTime = $backoff->generate(4);

        $this->assertGreaterThanOrEqual(2500, $backoffTime->asMilliseconds());
        $this->assertLessThanOrEqual(5000, $backoffTime->asMilliseconds());
    }
}
