<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Strategy\LinearStrategy;
use PHPUnit\Framework\TestCase;

final class LinearStrategyTest extends TestCase
{
    /**
     * @dataProvider getLinearStrategyData
     */
    public function testLinearStrategy(int $attempt, int $time, int $expectedTime): void
    {
        $strategy = new LinearStrategy();

        $actualTime = $strategy->calculate($attempt, $time);

        $this->assertEquals($expectedTime, $actualTime);
    }

    public function getLinearStrategyData(): array
    {
        return [
            [0, 1_000, 0],
            [1, 1_000, 1_000],
            [2, 1_000, 2_000],
            [3, 1_000, 3_000],
            [4, 1_000, 4_000],
            [5, 1_000, 5_000],
            [6, 0, 0],
        ];
    }
}
