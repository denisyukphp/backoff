<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Generator;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Strategy\StrategyInterface;

final class Generator implements GeneratorInterface
{
    public function __construct(
        private DurationInterface $baseTime,
        private DurationInterface $capTime,
        private StrategyInterface $strategy,
        private JitterInterface $jitter,
    ) {
    }

    public function generate(int $attempt): DurationInterface
    {
        $sleepTime = $this->strategy->calculate($this->baseTime, $attempt);

        $duration = $this->min($this->capTime, $sleepTime);

        return $this->jitter->jitter($duration);
    }

    private function min(DurationInterface ...$durations): DurationInterface
    {
        $values = array_map(function (DurationInterface $duration): float {
            return $duration->asNanoseconds();
        }, $durations);

        $nanoseconds = min($values);

        return new Nanoseconds($nanoseconds);
    }
}
