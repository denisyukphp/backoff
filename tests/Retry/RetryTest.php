<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\ImmediatelyThrowableBackOff;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\Retry;
use PHPUnit\Framework\TestCase;

class RetryTest extends TestCase
{
    public function testReturnValue(): void
    {
        $retry = new Retry(
            backOff: new ImmediatelyThrowableBackOff(),
            exceptionClassifier: new ExceptionClassifier(),
        );

        $result = $retry->call(fn (int $a, int $b): int => $a + $b, [5, 10]);

        $this->assertSame(15, $result);
    }

    public function testThrowException(): void
    {
        $retry = new Retry(
            backOff: new ImmediatelyThrowableBackOff(),
            exceptionClassifier: new ExceptionClassifier(),
        );

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $retry->call(fn () => throw $throwable);
    }

    public function testAttemptsCounter(): void
    {
        $retry = new Retry(
            backOff: $attemptsCounterBackOff = new AttemptsCounterBackOff(maxAttempts: 3),
            exceptionClassifier: new ExceptionClassifier(),
        );

        try {
            $retry->call(fn () => throw new \Exception());
        } catch (\Exception) {
            $this->assertSame(3, $attemptsCounterBackOff->getLastAttempt());
        }
    }
}
