<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Jitter;

use Orangesoft\BackOff\Jitter\FullJitter;
use PHPUnit\Framework\TestCase;

final class FullJitterTest extends TestCase
{
    /**
     * @param float[] $expectedTime
     *
     * @dataProvider getFullJitterData
     */
    public function testFullJitter(int $time, array $expectedTime): void
    {
        $jitter = new FullJitter();

        $actualTime = $jitter->jitter($time);

        $this->assertGreaterThanOrEqual($expectedTime[0], $actualTime);
        $this->assertLessThanOrEqual($expectedTime[1], $actualTime);
    }

    public function getFullJitterData(): array
    {
        return [
            [0, [0, 0]],
            [1_000, [0, 1_000]],
            [2_000, [0, 2_000]],
            [3_000, [0, 3_000]],
            [4_000, [0, 4_000]],
            [5_000, [0, 5_000]],
        ];
    }
}
