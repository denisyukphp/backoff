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
        private Duration $baseTime,
        private Duration $capTime,
        private GeneratorInterface $generator,
        private SleeperInterface $sleeper,
    ) {
    }

    public function backOff(int $attempt): void
    {
        Assertion::greaterThan($attempt, 0); // @codeCoverageIgnore

        $sleepTime = $this->generator->generate(
            attempt: $attempt,
            baseTime: $this->baseTime->asNanoseconds(),
            capTime: $this->capTime->asNanoseconds(),
        );

        $this->sleeper->sleep(new Nanoseconds($sleepTime));
    }
}
