<?php

namespace Orangesoft\BackOff\Facade;

use Orangesoft\BackOff\BackOff;
use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Jitter\DummyJitter;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\LinearStrategy;

final class LinearBackOff implements BackOffInterface
{
    /**
     * @var BackOffInterface
     */
    private $backOff;

    public function __construct(
        float $maxAttempts = 5,
        int $baseTimeMs = 1000,
        int $capTimeMs = 60 * 1000,
        ?JitterInterface $jitter = null,
        ?SleeperInterface $sleeper = null
    ) {
        $jitter = $jitter ?? new DummyJitter();
        $sleeper = $sleeper ?? new Sleeper();
        $generator = GeneratorBuilder::create()
            ->setMaxAttempts($maxAttempts)
            ->setBaseTime(new Milliseconds($baseTimeMs))
            ->setCapTime(new Milliseconds($capTimeMs))
            ->setStrategy(new LinearStrategy())
            ->setJitter($jitter)
            ->build()
        ;

        $this->backOff = new BackOff($generator, $sleeper);
    }

    /**
     * @param int $attempt
     * @param \Throwable $throwable
     *
     * @throws \Throwable
     */
    public function backOff(int $attempt, \Throwable $throwable): void
    {
        $this->backOff->backOff($attempt, $throwable);
    }
}
