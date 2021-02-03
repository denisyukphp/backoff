<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ConstantBackoff;

class ConstantBackoffTest extends TestCase
{
    public function testConstant(): void
    {
        $backoff = new ConstantBackoff(new Milliseconds(1000));

        $backoffTime = $backoff->generate(4);

        $this->assertEquals(1000, $backoffTime->toMilliseconds());
    }
}
