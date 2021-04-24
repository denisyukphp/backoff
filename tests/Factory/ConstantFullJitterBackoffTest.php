<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ConstantFullJitterBackoff;

class ConstantFullJitterBackoffTest extends TestCase
{
    public function testConstantFullJitter(): void
    {
        $backoff = new ConstantFullJitterBackoff(new Milliseconds(1000));

        $backoffTime = $backoff->generate(4);

        $this->assertGreaterThanOrEqual(0, $backoffTime->asMilliseconds());
        $this->assertLessThanOrEqual(1000, $backoffTime->asMilliseconds());
    }
}
