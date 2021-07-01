<?php

namespace Orangesoft\BackOff\Tests\Generator;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Strategy\ConstantStrategy;
use Orangesoft\BackOff\Strategy\LinearStrategy;
use Orangesoft\BackOff\Strategy\StrategyInterface;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\JitterInterface;

class GeneratorBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = GeneratorBuilder::create();

        $this->assertInstanceOf(GeneratorBuilder::class, $builder);
    }

    public function testDefaults(): void
    {
        $builder = GeneratorBuilder::create();

        $this->assertSame(INF, $builder->getMaxAttempts());
        $this->assertEquals(1000, $builder->getBaseTime()->asMilliseconds());
        $this->assertEquals(60 * 1000, $builder->getCapTime()->asMilliseconds());
        $this->assertInstanceOf(ConstantStrategy::class, $builder->getStrategy());
        $this->assertInstanceOf(DummyJitter::class, $builder->getJitter());
    }

    public function testMaxAttempts(): void
    {
        $builder = GeneratorBuilder::create()->setMaxAttempts(3);

        $this->assertEquals(3, $builder->getMaxAttempts());
    }

    public function testMaxAttemptsInf(): void
    {
        $builder = GeneratorBuilder::create()->setMaxAttempts(INF);

        $this->assertEquals(INF, $builder->getMaxAttempts());
    }

    public function testBaseTime(): void
    {
        $builder = GeneratorBuilder::create()->setBaseTime(new Milliseconds(1000));

        $this->assertInstanceOf(DurationInterface::class, $builder->getBaseTime());
    }

    public function testCapTime(): void
    {
        $builder = GeneratorBuilder::create()->setCapTime(new Milliseconds(1000));

        $this->assertInstanceOf(DurationInterface::class, $builder->getCapTime());
    }

    public function testStrategy(): void
    {
        $builder = GeneratorBuilder::create()->setStrategy(new LinearStrategy());

        $this->assertInstanceOf(StrategyInterface::class, $builder->getStrategy());
    }

    public function testJitter(): void
    {
        $builder = GeneratorBuilder::create()->setJitter(new FullJitter());

        $this->assertInstanceOf(JitterInterface::class, $builder->getJitter());
    }

    public function testBuild(): void
    {
        $generator = GeneratorBuilder::create()->build();

        $this->assertInstanceOf(Generator::class, $generator);
    }
}
