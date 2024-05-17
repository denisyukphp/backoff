<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\Duration\Microseconds;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\LinearBackOff;
use Orangesoft\BackOff\Retry\BackOffRetry;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Tests\CallbackSpy;
use Orangesoft\BackOff\Tests\SleeperSpy;
use PHPUnit\Framework\TestCase;

final class BackOffRetryTest extends TestCase
{
    public function testSuccessfulCall(): void
    {
        $backOffRetry = new BackOffRetry(
            maxAttempts: 3,
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            backOff: new LinearBackOff(),
            exceptionClassifier: new ExceptionClassifier(),
        );

        /** @var float $result */
        $result = $backOffRetry->call(static fn (): float => 1.618);

        $this->assertEquals(1.618, $result);
    }

    public function testFailureRetryableCall(): void
    {
        $sleeperSpy = new SleeperSpy();
        $backOffRetry = new BackOffRetry(
            maxAttempts: 3,
            baseTime: new Microseconds(1_000),
            capTime: new Microseconds(5_000),
            backOff: new LinearBackOff(
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
            $backOffRetry->call(new CallbackSpy(function (int $counter): never {
                throw new \RuntimeException(sprintf('Exception thrown %d times.', $counter));
            }));
        } catch (\RuntimeException $e) {
            $this->assertSame('Exception thrown 2 times.', $e->getMessage());
            $this->assertEquals(3_000, $sleeperSpy->getSleepTime()?->asMicroseconds());
        }
    }
}
