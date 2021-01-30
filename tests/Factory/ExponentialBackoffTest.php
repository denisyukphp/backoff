<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ExponentialBackoff;

class ExponentialBackoffTest extends TestCase
{
    public function testExponential(): void
    {
        $backoff = new ExponentialBackoff(new Milliseconds(1000));

        $nextTime = $backoff->getNextTime(4);

        $this->assertEquals(16000, $nextTime->toMilliseconds());
    }
}
