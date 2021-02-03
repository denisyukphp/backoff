<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ConstantEqualJitterBackoff;

class ConstantEqualJitterBackoffTest extends TestCase
{
    public function testConstantEqualJitter(): void
    {
        $backoff = new ConstantEqualJitterBackoff(new Milliseconds(1000));

        $backoffTime = $backoff->generate(4);

        $this->assertGreaterThanOrEqual(500, $backoffTime->toMilliseconds());
        $this->assertLessThanOrEqual(1000, $backoffTime->toMilliseconds());
    }
}
