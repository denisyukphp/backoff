<?php

namespace Orangesoft\BackOff\Tests\Generator;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\LinearStrategy;
use Orangesoft\BackOff\Generator\Exception\MaxAttemptsException;

class GeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $generator = GeneratorBuilder::create()
            ->setBaseTime(new Milliseconds(1000))
            ->setCapTime(new Milliseconds(60 * 1000))
            ->setStrategy(new LinearStrategy())
            ->build()
        ;

        $duration = $generator->generate(3);

        $this->assertEquals(4000, $duration->asMilliseconds());
    }

    public function testGenerateCapTime(): void
    {
        $generator = GeneratorBuilder::create()
            ->setBaseTime(new Milliseconds(1000))
            ->setCapTime(new Milliseconds(500))
            ->setStrategy(new LinearStrategy())
            ->build()
        ;

        $duration = $generator->generate(3);

        $this->assertEquals(500, $duration->asMilliseconds());
    }

    public function testGenerateMaxAttemptsReached(): void
    {
        $generator = GeneratorBuilder::create()->setMaxAttempts(3)->build();

        $this->expectException(MaxAttemptsException::class);

        $generator->generate(3);
    }
}
