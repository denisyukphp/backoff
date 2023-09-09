<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Jitter;

use Orangesoft\BackOff\Jitter\EqualJitter;
use PHPUnit\Framework\TestCase;

final class EqualJitterTest extends TestCase
{
    /**
     * @param float[] $expectedTime
     *
     * @dataProvider getEqualJitterData
     */
    public function testFullJitter(int $time, array $expectedTime): void
    {
        $equalJitter = new EqualJitter();

        $actualTime = $equalJitter->jitter($time);

        $this->assertGreaterThanOrEqual($expectedTime[0], $actualTime);
        $this->assertLessThanOrEqual($expectedTime[1], $actualTime);
    }

    public function getEqualJitterData(): array
    {
        return [
            [0, [0, 0]],
            [1_000, [500, 1_000]],
            [2_000, [1_000, 2_000]],
            [3_000, [1_500, 3_000]],
            [4_000, [2_000, 4_000]],
            [5_000, [2_500, 5_000]],
        ];
    }
}
