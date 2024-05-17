<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Strategy\DecorrelatedJitterStrategy;
use PHPUnit\Framework\TestCase;

final class DecorrelatedJitterStrategyTest extends TestCase
{
    /**
     * @param float[] $expectedTime
     *
     * @dataProvider getDecorrelatedJitterStrategyData
     */
    public function testDecorrelatedJitterStrategy(float $multiplier, int $attempt, float $time, array $expectedTime): void
    {
        $decorrelatedJitterStrategy = new DecorrelatedJitterStrategy($multiplier);

        $actualTime = $decorrelatedJitterStrategy->calculate($attempt, $time);

        $this->assertGreaterThanOrEqual($expectedTime[0], $actualTime);
        $this->assertLessThanOrEqual($expectedTime[1], $actualTime);
    }

    public function getDecorrelatedJitterStrategyData(): array
    {
        return [
            [3.0, 0, 1_000, [0, 0]],
            [3.0, 1, 1_000, [1_000, 3_000]],
            [3.0, 2, 1_000, [1_000, 6_000]],
            [3.0, 3, 1_000, [1_000, 9_000]],
            [3.0, 4, 1_000, [1_000, 12_000]],
            [3.0, 5, 1_000, [1_000, 15_000]],
            [3.0, 6, 0, [0, 0]],
            [0.0, 7, 0, [0, 0]],
        ];
    }
}
