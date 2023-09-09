<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Generator;

use Assert\Assertion;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Strategy\StrategyInterface;

final class Generator implements GeneratorInterface
{
    public function __construct(
        private StrategyInterface $strategy,
        private JitterInterface $jitter,
    ) {
    }

    public function generate(int $attempt, float $baseTime, float $capTime): float
    {
        // @codeCoverageIgnoreStart
        Assertion::greaterOrEqualThan($attempt, 0);
        Assertion::greaterOrEqualThan($baseTime, 0);
        Assertion::greaterOrEqualThan($capTime, 0);
        // @codeCoverageIgnoreEnd

        $backOffTime = $this->strategy->calculate($attempt, $baseTime);
        $jitterTime = $this->jitter->jitter($backOffTime);

        return min($jitterTime, $capTime);
    }
}
