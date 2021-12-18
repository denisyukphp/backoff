<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Strategy\LinearStrategy;
use Orangesoft\BackOff\Duration\Nanoseconds;
use PHPUnit\Framework\TestCase;

class LinearStrategyTest extends TestCase
{
    /**
     * @dataProvider expectedNanosecondsDataset
     */
    public function testCalculate(int $attempt, int $expectedNanoseconds): void
    {
        $linearStrategy = new LinearStrategy();

        $duration = $linearStrategy->calculate(new Nanoseconds(1_000), $attempt);

        $this->assertEquals($expectedNanoseconds, $duration->asNanoseconds());
    }

    public function expectedNanosecondsDataset(): array
    {
        return [
            [1, 1_000],
            [2, 2_000],
            [3, 3_000],
        ];
    }
}
