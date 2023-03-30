<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Strategy\DecorrelatedStrategy;
use PHPUnit\Framework\TestCase;

class DecorrelatedStrategyTest extends TestCase
{
    /**
     * @dataProvider expectedNanosecondsDataset
     */
    public function testCalculate(int $attempt, int $expectedNanosecondsMin, int $expectedNanosecondsMax): void
    {
        $decorrelatedStrategy = new DecorrelatedStrategy(multiplier: 3);

        $duration = $decorrelatedStrategy->calculate(new Nanoseconds(1_000), $attempt);

        $this->assertGreaterThanOrEqual($expectedNanosecondsMin, $duration->asNanoseconds());
        $this->assertLessThanOrEqual($expectedNanosecondsMax, $duration->asNanoseconds());
    }

    public function expectedNanosecondsDataset(): array
    {
        return [
            [1, 1_000, 3_000],
            [2, 1_000, 9_000],
            [3, 1_000, 27_000],
        ];
    }
}
