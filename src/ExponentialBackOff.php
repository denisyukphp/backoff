<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;

final class ExponentialBackOff extends BackOff
{
    public function __construct(
        Duration $baseTime,
        Duration $capTime,
        float $factor = 2.0,
        ?JitterInterface $jitter = null,
        ?SleeperInterface $sleeper = null,
    ) {
        $strategy = new ExponentialStrategy($factor);
        $jitter ??= new NullJitter();
        $generator = new Generator($strategy, $jitter);
        $sleeper ??= new Sleeper();

        parent::__construct($baseTime, $capTime, $generator, $sleeper);
    }
}
