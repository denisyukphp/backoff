<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Strategy\FibonacciStrategy;

final class FibonacciBackOff extends BackOff
{
    public function __construct(?JitterInterface $jitter = null, ?SleeperInterface $sleeper = null)
    {
        $strategy = new FibonacciStrategy();
        $jitter ??= new NullJitter();
        $generator = new Generator($strategy, $jitter);
        $sleeper ??= new Sleeper();

        parent::__construct($generator, $sleeper);
    }
}
