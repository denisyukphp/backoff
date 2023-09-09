<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;
use Orangesoft\BackOff\Jitter\FullJitter;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Jitter\ScatteredJitter;
use Orangesoft\BackOff\PermanentBackOff;
use PHPUnit\Framework\TestCase;

final class PermanentBackOffTest extends TestCase
{
    private Duration $baseTime;
    private Duration $capTime;
    private SleeperSpy $sleeperSpy;

    protected function setUp(): void
    {
        $this->baseTime = new Microseconds(1_000);
        $this->capTime = new Microseconds(5_000);
        $this->sleeperSpy = new SleeperSpy();
    }

    /**
     * @dataProvider getPermanentData
     */
    public function testPermanentBackOff(int $attempt, int $expectedSleepTime): void
    {
        $permanentBackOff = new PermanentBackOff(new NullJitter(), $this->sleeperSpy);

        $permanentBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertEquals($expectedSleepTime, $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getPermanentData(): array
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
     * @dataProvider getPermanentDataWithEqualJitter
     */
    public function testPermanentBackOffWithEqualJitter(int $attempt, array $expectedSleepTime): void
    {
        $permanentBackOff = new PermanentBackOff(new EqualJitter(), $this->sleeperSpy);

        $permanentBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getPermanentDataWithEqualJitter(): array
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
     * @dataProvider getPermanentDataWithFullJitter
     */
    public function testPermanentBackOffWithFullJitter(int $attempt, array $expectedSleepTime): void
    {
        $permanentBackOff = new PermanentBackOff(new FullJitter(), $this->sleeperSpy);

        $permanentBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getPermanentDataWithFullJitter(): array
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
     * @dataProvider getPermanentDataWithScatteredJitter
     */
    public function testPermanentBackOffWithScatteredJitter(int $attempt, float $range, array $expectedSleepTime): void
    {
        $permanentBackOff = new PermanentBackOff(new ScatteredJitter($range), $this->sleeperSpy);

        $permanentBackOff->backOff($attempt, $this->baseTime, $this->capTime);

        $this->assertGreaterThanOrEqual($expectedSleepTime[0], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
        $this->assertLessThanOrEqual($expectedSleepTime[1], $this->sleeperSpy->getSleepTime()?->asMicroseconds());
    }

    public function getPermanentDataWithScatteredJitter(): array
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
