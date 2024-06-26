<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Jitter\ScatteredJitter;
use PHPUnit\Framework\TestCase;

final class ExponentialBackOffTest extends TestCase
{
    /**
     * @dataProvider getExponentialData
     */
    public function testExponentialBackOff(int $attempt, int $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ExponentialBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(16_000),
            factor: 2.0,
            jitter: new NullJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertEquals($expectedSleepTime, $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getExponentialData(): array
    {
        return [
            [1, 1_000],
            [2, 2_000],
            [3, 4_000],
            [4, 8_000],
            [5, 16_000],
            [6, 16_000],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getExponentialDataWithEqualJitter
     */
    public function testExponentialBackOffWithEqualJitter(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ExponentialBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(16_000),
            factor: 2.0,
            jitter: new EqualJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getExponentialDataWithEqualJitter(): array
    {
        return [
            [1, [500, 1_000]],
            [2, [1_000, 2_000]],
            [3, [2_000, 4_000]],
            [4, [4_000, 8_000]],
            [5, [8_000, 16_000]],
            [6, [16_000, 16_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getExponentialDataWithFullJitter
     */
    public function testExponentialBackOffWithFullJitter(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ExponentialBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(16_000),
            factor: 2.0,
            jitter: new FullJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getExponentialDataWithFullJitter(): array
    {
        return [
            [1, [0, 1_000]],
            [2, [0, 2_000]],
            [3, [0, 4_000]],
            [4, [0, 8_000]],
            [5, [0, 16_000]],
            [6, [0, 16_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getExponentialDataWithScatteredJitter
     */
    public function testExponentialBackOffWithScatteredJitter(int $attempt, float $range, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ExponentialBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(16_000),
            factor: 2.0,
            jitter: new ScatteredJitter($range),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getExponentialDataWithScatteredJitter(): array
    {
        return [
            [1, 0.5, [500, 1_500]],
            [2, 0.5, [1_000, 3_000]],
            [3, 0.5, [2_000, 6_000]],
            [4, 0.5, [4_000, 12_000]],
            [5, 0.5, [8_000, 16_000]],
            [6, 0.5, [16_000, 16_000]],
        ];
    }
}
