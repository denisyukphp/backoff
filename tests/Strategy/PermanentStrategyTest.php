<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Strategy\PermanentStrategy;
use PHPUnit\Framework\TestCase;

final class PermanentStrategyTest extends TestCase
{
    /**
     * @dataProvider getConstantStrategyData
     */
    public function testConstantStrategy(int $attempt, float $time, float $expectedTime): void
    {
        $permanentStrategy = new PermanentStrategy();

        $actualTime = $permanentStrategy->calculate($attempt, $time);

        $this->assertEquals($expectedTime, $actualTime);
    }

    public function getConstantStrategyData(): array
    {
        return [
            [0, 1_000, 0],
            [1, 1_000, 1_000],
            [2, 1_000, 1_000],
            [3, 1_000, 1_000],
            [4, 1_000, 1_000],
            [5, 1_000, 1_000],
            [6, 0, 0],
        ];
    }
}
