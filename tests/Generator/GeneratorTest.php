<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Generator;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Strategy\ConstantStrategy;
use Orangesoft\BackOff\Strategy\LinearStrategy;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testMinTime(): void
    {
        $generator = new Generator(
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            strategy: new ConstantStrategy(),
            jitter: new NullJitter(),
        );

        $duration = $generator->generate(1);

        $this->assertEquals(1_000, $duration->asNanoseconds());
    }

    public function testMaxTime(): void
    {
        $generator = new Generator(
            baseTime: new Nanoseconds(60_000),
            capTime: new Nanoseconds(1_000),
            strategy: new ConstantStrategy(),
            jitter: new NullJitter(),
        );

        $duration = $generator->generate(1);

        $this->assertEquals(1_000, $duration->asNanoseconds());
    }

    public function testReturnDuration(): void
    {
        $generator = new Generator(
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            strategy: new LinearStrategy(),
            jitter: new EqualJitter(),
        );

        $duration = $generator->generate(3);

        $this->assertGreaterThanOrEqual(1_500, $duration->asNanoseconds());
        $this->assertLessThanOrEqual(3_000, $duration->asNanoseconds());
    }
}
