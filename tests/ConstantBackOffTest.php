<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\ConstantBackOff;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Jitter\ScatteredJitter;
use PHPUnit\Framework\TestCase;

final class ConstantBackOffTest extends TestCase
{
    /**
     * @dataProvider getConstantData
     */
    public function testConstantBackOff(int $attempt, int $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ConstantBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new NullJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertEquals($expectedSleepTime, $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getConstantData(): array
    {
        return [
            [1, 1_000],
            [2, 1_000],
            [3, 1_000],
            [4, 1_000],
            [5, 1_000],
            [6, 1_000],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getConstantDataWithEqualJitter
     */
    public function testConstantBackOffWithEqualJitter(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ConstantBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new EqualJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getConstantDataWithEqualJitter(): array
    {
        return [
            [1, [500, 1_000]],
            [2, [500, 1_000]],
            [3, [500, 1_000]],
            [4, [500, 1_000]],
            [5, [500, 1_000]],
            [6, [500, 1_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getConstantDataWithFullJitter
     */
    public function testConstantBackOffWithFullJitter(int $attempt, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ConstantBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new FullJitter(),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getConstantDataWithFullJitter(): array
    {
        return [
            [1, [0, 1_000]],
            [2, [0, 1_000]],
            [3, [0, 1_000]],
            [4, [0, 1_000]],
            [5, [0, 1_000]],
            [6, [0, 1_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getConstantDataWithScatteredJitter
     */
    public function testConstantBackOffWithScatteredJitter(int $attempt, float $range, array $expectedSleepTime): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOff = new ConstantBackOff(
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            jitter: new ScatteredJitter($range),
            sleeper: $sleeperSpy,
        );

        $backOff->backOff($attempt);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getConstantDataWithScatteredJitter(): array
    {
        return [
            [1, 0.5, [500, 1_500]],
            [2, 0.5, [500, 1_500]],
            [3, 0.5, [500, 1_500]],
            [4, 0.5, [500, 1_500]],
            [5, 0.5, [500, 1_500]],
            [6, 0.5, [500, 1_500]],
        ];
    }
}
