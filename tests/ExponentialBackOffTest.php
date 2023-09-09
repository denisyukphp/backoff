<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Jitter\ScatteredJitter;
use PHPUnit\Framework\TestCase;

final class ExponentialBackOffTest extends TestCase
{
    private float $multiplier;
    private Duration $baseTime;
    private Duration $capTime;
    private SleeperSpy $sleeperSpy;

    protected function setUp(): void
    {
        $this->multiplier = 2;
        $this->baseTime = new Microseconds(1_000);
        $this->capTime = new Microseconds(16_000);
        $this->sleeperSpy = new SleeperSpy();
    }

    /**
     * @dataProvider getExponentialData
     */
    public function testExponentialBackOff(int $attempt, int $expectedSleepTime): void
    {
        $exponentialBackOff = new ExponentialBackOff($this->multiplier, new NullJitter(), $this->sleeperSpy);

        $exponentialBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertEquals($expectedSleepTime, $this->sleeperSpy->getSleepTime()?->asMicroseconds());
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
        $exponentialBackOff = new ExponentialBackOff($this->multiplier, new EqualJitter(), $this->sleeperSpy);

        $exponentialBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
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
        $exponentialBackOff = new ExponentialBackOff($this->multiplier, new FullJitter(), $this->sleeperSpy);

        $exponentialBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
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
        $exponentialBackOff = new ExponentialBackOff($this->multiplier, new ScatteredJitter($range), $this->sleeperSpy);

        $exponentialBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
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
