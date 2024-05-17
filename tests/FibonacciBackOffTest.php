<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\FibonacciBackOff;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Jitter\ScatteredJitter;
use PHPUnit\Framework\TestCase;

final class FibonacciBackOffTest extends TestCase
{
    private Duration $baseTime;
    private Duration $capTime;
    private SleeperSpy $sleeperSpy;

    protected function setUp(): void
    {
        $this->baseTime = new Microseconds(1_000);
        $this->capTime = new Microseconds(21_000);
        $this->sleeperSpy = new SleeperSpy();
    }

    /**
     * @dataProvider getFibonacciData
     */
    public function testFibonacciBackOff(int $attempt, int $expectedSleepTime): void
    {
        $fibonacciBackOff = new FibonacciBackOff(new NullJitter(), $this->sleeperSpy);

        $fibonacciBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertEquals($expectedSleepTime, (int) $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getFibonacciData(): array
    {
        return [
            [1, 1_000],
            [2, 1_000],
            [3, 2_000],
            [4, 3_000],
            [5, 5_000],
            [6, 8_000],
            [7, 13_000],
            [8, 21_000],
            [9, 21_000],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getFibonacciDataWithEqualJitter
     */
    public function testFibonacciBackOffWithEqualJitter(int $attempt, array $expectedSleepTime): void
    {
        $fibonacciBackOff = new FibonacciBackOff(new EqualJitter(), $this->sleeperSpy);

        $fibonacciBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getFibonacciDataWithEqualJitter(): array
    {
        return [
            [1, [500, 1_000]],
            [2, [500, 1_000]],
            [3, [1_000, 2_000]],
            [4, [1_500, 3_000]],
            [5, [2_500, 5_000]],
            [6, [4_000, 8_000]],
            [7, [6_500, 13_000]],
            [8, [10_500, 21_000]],
            [9, [10_500, 21_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getFibonacciDataWithFullJitter
     */
    public function testFibonacciBackOffWithFullJitter(int $attempt, array $expectedSleepTime): void
    {
        $fibonacciBackOff = new FibonacciBackOff(new FullJitter(), $this->sleeperSpy);

        $fibonacciBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getFibonacciDataWithFullJitter(): array
    {
        return [
            [1, [0, 1_000]],
            [2, [0, 1_000]],
            [3, [0, 2_000]],
            [4, [0, 3_000]],
            [5, [0, 5_000]],
            [6, [0, 8_000]],
            [7, [0, 13_000]],
            [8, [0, 21_000]],
            [9, [0, 21_000]],
        ];
    }

    /**
     * @param float[] $expectedSleepTime
     *
     * @dataProvider getFibonacciDataWithScatteredJitter
     */
    public function testFibonacciBackOffWithScatteredJitter(int $attempt, float $range, array $expectedSleepTime): void
    {
        $fibonacciBackOff = new FibonacciBackOff(new ScatteredJitter($range), $this->sleeperSpy);

        $fibonacciBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getFibonacciDataWithScatteredJitter(): array
    {
        return [
            [1, 0.5, [500, 1_500]],
            [2, 0.5, [500, 1_500]],
            [3, 0.5, [1_000, 3_000]],
            [4, 0.5, [1_500, 4_500]],
            [5, 0.5, [2_500, 7_500]],
            [6, 0.5, [4_000, 12_000]],
            [7, 0.5, [6_500, 19_500]],
            [8, 0.5, [10_500, 21_000]],
            [9, 0.5, [10_500, 21_000]],
        ];
    }
}
