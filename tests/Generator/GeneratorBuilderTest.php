<?php

namespace Orangesoft\BackOff\Tests\Generator;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use Orangesoft\BackOff\Strategy\LinearStrategy;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Jitter\FullJitter;

class GeneratorBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $generatorBuilder = GeneratorBuilder::create();

        $this->assertInstanceOf(GeneratorBuilder::class, $generatorBuilder);
    }

    public function testDefault(): void
    {
        $generatorBuilder = GeneratorBuilder::create();

        $this->assertSame(INF, $generatorBuilder->getMaxAttempts());
        $this->assertEquals(1000, $generatorBuilder->getBaseTime()->asMilliseconds());
        $this->assertEquals(60 * 1000, $generatorBuilder->getCapTime()->asMilliseconds());
        $this->assertInstanceOf(ExponentialStrategy::class, $generatorBuilder->getStrategy());
        $this->assertInstanceOf(DummyJitter::class, $generatorBuilder->getJitter());
    }

    public function testMaxAttempts(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->setMaxAttempts(3);

        $this->assertEquals(3, $generatorBuilder->getMaxAttempts());
    }

    public function testMaxAttemptsInf(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->setMaxAttempts(INF);

        $this->assertEquals(INF, $generatorBuilder->getMaxAttempts());
    }

    public function testBaseTime(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->setBaseTime(new Milliseconds(1000));

        $this->assertInstanceOf(Milliseconds::class, $generatorBuilder->getBaseTime());
    }

    public function testCapTime(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->setCapTime(new Milliseconds(1000));

        $this->assertInstanceOf(Milliseconds::class, $generatorBuilder->getCapTime());
    }

    public function testStrategy(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->setStrategy(new LinearStrategy());

        $this->assertInstanceOf(LinearStrategy::class, $generatorBuilder->getStrategy());
    }

    public function testJitter(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->setJitter(new FullJitter());

        $this->assertInstanceOf(FullJitter::class, $generatorBuilder->getJitter());
    }

    public function testBuild(): void
    {
        $generatorBuilder = GeneratorBuilder::create()->build();

        $this->assertInstanceOf(Generator::class, $generatorBuilder);
    }
}
