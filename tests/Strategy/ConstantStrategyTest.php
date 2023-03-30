<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Strategy;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Strategy\ConstantStrategy;
use PHPUnit\Framework\TestCase;

class ConstantStrategyTest extends TestCase
{
    /**
     * @dataProvider expectedNanosecondsDataset
     */
    public function testCalculate(int $attempt, int $expectedNanoseconds): void
    {
        $constantStrategy = new ConstantStrategy();

        $duration = $constantStrategy->calculate(new Nanoseconds(1_000), $attempt);

        $this->assertEquals($expectedNanoseconds, $duration->asNanoseconds());
    }

    public function expectedNanosecondsDataset(): array
    {
        return [
            [1, 1_000],
            [2, 1_000],
            [3, 1_000],
        ];
    }
}
