<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Strategy\FibonacciStrategy;
use PHPUnit\Framework\TestCase;

final class FibonacciStrategyTest extends TestCase
{
    /**
     * @dataProvider getFibonacciStrategyData
     */
    public function testFibonacciStrategy(int $attempt, float $time, float $expectedTime): void
    {
        $fibonacciStrategy = new FibonacciStrategy();

        $actualTime = (int) $fibonacciStrategy->calculate($attempt, $time);

        $this->assertEquals($expectedTime, $actualTime);
    }

    public function getFibonacciStrategyData(): array
    {
        return [
            [0, 1_000, 0],
            [1, 1_000, 1_000],
            [2, 1_000, 1_000],
            [3, 1_000, 2_000],
            [4, 1_000, 3_000],
            [5, 1_000, 5_000],
            [6, 1_000, 8_000],
            [7, 1_000, 13_000],
            [8, 1_000, 21_000],
            [9, 0, 0],
        ];
    }
}
