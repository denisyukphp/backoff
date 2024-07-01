<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\DecorrelatedJitterBackOff;
use Orangesoft\BackOff\Duration\Microseconds;
use PHPUnit\Framework\TestCase;

final class DecorrelatedJitterBackOffTest extends TestCase
{
    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getDecorrelatedJitterData
     */
    public function testDecorrelatedJitterBackOff(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new DecorrelatedJitterBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(15_000),
            factor: 3.0,
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getDecorrelatedJitterData(): array
    {
        return [
            [1, [1_000, 3_000]],
            [2, [1_000, 6_000]],
            [3, [1_000, 9_000]],
            [4, [1_000, 12_000]],
            [5, [1_000, 15_000]],
            [6, [1_000, 15_000]],
        ];
    }
}
