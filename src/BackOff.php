<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Assert\Assertion;
use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Generator\GeneratorInterface;
use Orangesoft\BackOff\Sleeper\SleeperInterface;

abstract class BackOff implements BackOffInterface
{
    public function __construct(
        private GeneratorInterface $generator,
        private SleeperInterface $sleeper,
    ) {
    }

    public function backOff(int $attempt, Duration $baseTime, Duration $capTime): void
    {
        Assertion::greaterThan($attempt, 0); // @codeCoverageIgnore

        $sleepTime = $this->generator->generate($attempt, $baseTime->asNanoseconds(), $capTime->asNanoseconds());
        $this->sleeper->sleep(new Nanoseconds($sleepTime));
    }
}
