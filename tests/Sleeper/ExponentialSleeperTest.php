<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\ExponentialSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class ExponentialSleeperTest extends TestCase
{
    public function testExponential(): void
    {
        $sleeper = new ExponentialSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
