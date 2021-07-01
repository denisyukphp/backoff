<?php

namespace Orangesoft\BackOff\Tests;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Timer\Timer;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ConstantStrategy;
use Orangesoft\BackOff\BackOff;

class BackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $generator = GeneratorBuilder::create()
            ->setBaseTime(new Milliseconds(500))
            ->setCapTime(new Milliseconds(60 * 1000))
            ->setStrategy(new ConstantStrategy())
            ->build()
        ;

        $sleeper = new Sleeper();

        $backOff = new BackOff($generator, $sleeper);

        $timer = new Timer();

        $timer->start();

        $backOff->backOff(0, new \RuntimeException());

        $milliseconds = $timer->stop() * 1000;

        $this->assertGreaterThanOrEqual(500, $milliseconds);
    }

    public function testBackOffThrowable(): void
    {
        $generator = GeneratorBuilder::create()->setMaxAttempts(3)->build();

        $sleeper = new Sleeper();

        $backOff = new BackOff($generator, $sleeper);

        $this->expectException(\RuntimeException::class);

        $backOff->backOff(3, new \RuntimeException());
    }
}
