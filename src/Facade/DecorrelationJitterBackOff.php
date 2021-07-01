<?php

namespace Orangesoft\BackOff\Facade;

use Orangesoft\BackOff\BackOff;
use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Generator\GeneratorBuilder;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\DecorrelationJitterStrategy;

final class DecorrelationJitterBackOff implements BackOffInterface
{
    /**
     * @var BackOffInterface
     */
    private $backOff;

    public function __construct(
        float $maxAttempts = 5,
        int $baseTimeMs = 1000,
        int $capTimeMs = 60 * 1000,
        int $multiplier = 3,
        ?SleeperInterface $sleeper = null
    ) {
        $sleeper = $sleeper ?? new Sleeper();
        $generator = GeneratorBuilder::create()
            ->setMaxAttempts($maxAttempts)
            ->setBaseTime(new Milliseconds($baseTimeMs))
            ->setCapTime(new Milliseconds($capTimeMs))
            ->setStrategy(new DecorrelationJitterStrategy($multiplier))
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
