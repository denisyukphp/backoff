<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Jitter\ScatteredJitter;
use Orangesoft\BackOff\LinearBackOff;
use PHPUnit\Framework\TestCase;

final class LinearBackOffTest extends TestCase
{
    /**
     * @dataProvider getLinearData
     */
    public function testLinearBackOff(int $attempt, int $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new LinearBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new NullJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertEquals($expectedSleepTime, $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getLinearData(): array
    {
        return [
            [1, 1_000],
            [2, 2_000],
            [3, 3_000],
            [4, 4_000],
            [5, 5_000],
            [6, 5_000],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getLinearDataWithEqualJitter
     */
    public function testLinearBackOffWithEqualJitter(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new LinearBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new EqualJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getLinearDataWithEqualJitter(): array
    {
        return [
            [1, [500, 1_000]],
            [2, [1_000, 2_000]],
            [3, [1_500, 3_000]],
            [4, [2_000, 4_000]],
            [5, [2_500, 5_000]],
            [6, [3_000, 5_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getLinearDataWithFullJitter
     */
    public function testLinearBackOffWithFullJitter(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new LinearBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new FullJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getLinearDataWithFullJitter(): array
    {
        return [
            [1, [0, 1_000]],
            [2, [0, 2_000]],
            [3, [0, 3_000]],
            [4, [0, 4_000]],
            [5, [0, 5_000]],
            [6, [0, 5_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getLinearDataWithScatteredJitter
     */
    public function testLinearBackOffWithScatteredJitter(int $attempt, float $range, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new LinearBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new ScatteredJitter($range),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getLinearDataWithScatteredJitter(): array
    {
        return [
            [1, 0.5, [500, 1_500]],
            [2, 0.5, [1_000, 3_000]],
            [3, 0.5, [1_500, 4_500]],
            [4, 0.5, [2_000, 6_000]],
            [5, 0.5, [2_500, 5_000]],
            [6, 0.5, [2_500, 5_000]],
        ];
    }
}
