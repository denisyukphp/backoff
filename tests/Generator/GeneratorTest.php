<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Generator;

use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Strategy\LinearStrategy;
use PHPUnit\Framework\TestCase;

final class GeneratorTest extends TestCase
{
    public function testCapTime(): void
    {
        $generator = new Generator(new LinearStrategy(), new NullJitter());

        $actualTime = $generator->generate(
            attempt: 4,
            baseTime: 1,
            capTime: 3,
        );

        $this->assertEquals(3, $actualTime);
    }
}
