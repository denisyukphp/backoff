<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\DecorrelatedJitterBackOff;
use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Duration\Microseconds;
use PHPUnit\Framework\TestCase;

final class DecorrelatedJitterBackOffTest extends TestCase
{
    private float $multiplier;
    private Duration $baseTime;
    private Duration $capTime;
    private SleeperSpy $sleeperSpy;

    protected function setUp(): void
    {
        $this->multiplier = 3;
        $this->baseTime = new Microseconds(1_000);
        $this->capTime = new Microseconds(15_000);
        $this->sleeperSpy = new SleeperSpy();
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getDecorrelatedJitterData
     */
    public function testDecorrelatedJitterBackOff(int $attempt, array $expectedSleepTime): void
    {
        $decorrelatedJitterBackOff = new DecorrelatedJitterBackOff($this->multiplier, $this->sleeperSpy);

        $decorrelatedJitterBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
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
