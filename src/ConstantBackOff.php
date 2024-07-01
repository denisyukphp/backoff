<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Strategy\ConstantStrategy;

final class ConstantBackOff extends BackOff
{
    public function __construct(
        Duration $baseTime,
        Duration $capTime,
        ?JitterInterface $jitter = null,
        ?SleeperInterface $sleeper = null,
    ) {
        $strategy = new ConstantStrategy();
        $jitter ??= new NullJitter();
        $generator = new Generator($strategy, $jitter);
        $sleeper ??= new Sleeper();

        parent::__construct($baseTime, $capTime, $generator, $sleeper);
    }
}
