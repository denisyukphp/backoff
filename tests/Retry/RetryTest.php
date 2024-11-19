<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\LinearBackOff;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\Retry;
use Orangesoft\BackOff\Tests\CallbackSpy;
use Orangesoft\BackOff\Tests\SleeperSpy;
use PHPUnit\Framework\TestCase;

final class RetryTest extends TestCase
{
    public function testSuccessfulCall(): void
    {
        $retry = new Retry(3);

        /** @var float $result */
        $result = $retry->call(static fn (): float => 1.618);

        $this->assertEquals(1.618, $result);
    }

    public function testFailureRetryableCall(): void
    {
        $sleeperSpy = new SleeperSpy();
        $retry = new Retry(
            maxAttempts: 3,
            backOff: new LinearBackOff(
                baseTime: new Microseconds(1_000),
                capTime: new Microseconds(5_000),
                jitter: new NullJitter(),
                sleeper: $sleeperSpy,
            ),
            exceptionClassifier: new ExceptionClassifier(
                classNames: [
                    \RuntimeException::class,
                ],
            ),
        );

        try {
            $retry->call(new CallbackSpy(static function (int $counter): never {
                throw new \RuntimeException(\sprintf('Exception thrown %d times.', $counter));
            }));
        } catch (\RuntimeException $e) {
            $this->assertSame('Exception thrown 2 times.', $e->getMessage());
            $this->assertEquals(3_000, $sleeperSpy->getSleepTime()?->asMicroseconds());
        }
    }
}
