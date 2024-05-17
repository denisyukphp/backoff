<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use PHPUnit\Framework\TestCase;

final class ExponentialStrategyTest extends TestCase
{
    /**
     * @dataProvider getExponentialStrategyData
     */
    public function testExponentialStrategy(float $multiplier, int $attempt, float $time, float $expectedTime): void
    {
        $exponentialStrategy = new ExponentialStrategy($multiplier);

        $actualTime = $exponentialStrategy->calculate($attempt, $time);

        $this->assertEquals($expectedTime, $actualTime);
    }

    public function getExponentialStrategyData(): array
    {
        return [
            [2.0, 0, 1_000, 0],
            [2.0, 1, 1_000, 1_000],
            [2.0, 2, 1_000, 2_000],
            [2.0, 3, 1_000, 4_000],
            [2.0, 4, 1_000, 8_000],
            [2.0, 5, 1_000, 16_000],
            [2.0, 6, 0, 0],
            [0.0, 7, 0, 0],
        ];
    }
}
