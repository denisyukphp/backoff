<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;
use PHPUnit\Framework\TestCase;

class ExponentialStrategyTest extends TestCase
{
    /**
     * @dataProvider expectedNanosecondsDataset
     */
    public function testCalculate(int $attempt, int $expectedNanoseconds): void
    {
        $exponentialStrategy = new ExponentialStrategy(multiplier: 2);

        $duration = $exponentialStrategy->calculate(new Nanoseconds(1_000), $attempt);

        $this->assertEquals($expectedNanoseconds, $duration->asNanoseconds());
    }

    public function expectedNanosecondsDataset(): array
    {
        return [
            [1, 2_000],
            [2, 4_000],
            [3, 8_000],
        ];
    }
}
