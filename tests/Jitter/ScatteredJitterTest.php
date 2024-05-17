<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Jitter;

use Orangesoft\BackOff\Jitter\ScatteredJitter;
use PHPUnit\Framework\TestCase;

final class ScatteredJitterTest extends TestCase
{
    /**
     * @param float[] $expectedTime
     *
     * @dataProvider getScatteredJitterData
     */
    public function testFullJitter(float $range, int $time, array $expectedTime): void
    {
        $scatteredJitter = new ScatteredJitter($range);

        $actualTime = $scatteredJitter->jitter($time);

        $this->assertGreaterThanOrEqual($expectedTime[0], $actualTime);
        $this->assertLessThanOrEqual($expectedTime[1], $actualTime);
    }

    public function getScatteredJitterData(): array
    {
        return [
            [0.5, 0, [0, 0]],
            [0.5, 1_000, [500, 1_500]],
            [0.5, 2_000, [1_000, 3_000]],
            [0.5, 3_000, [1_500, 4_500]],
            [0.5, 4_000, [2_000, 6_000]],
            [0.5, 5_000, [2_500, 7_500]],
        ];
    }
}
