<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Retry\Retry;
use Orangesoft\BackOff\Tests\CallbackSpy;
use PHPUnit\Framework\TestCase;

final class RetryTest extends TestCase
{
    public function testSuccessfulCall(): void
    {
        $retry = new Retry(
            maxAttempts: 3,
            exceptionClassifier: new ExceptionClassifier(),
        );

        /** @var float $result */
        $result = $retry->call(static fn (): float => 1.618);

        $this->assertEquals(1.618, $result);
    }

    public function testFailureRetryableCall(): void
    {
        $retry = new Retry(
            maxAttempts: 3,
            exceptionClassifier: new ExceptionClassifier(
                classNames: [
                    \RuntimeException::class,
                ],
            ),
        );

        try {
            $retry->call(new CallbackSpy(function (int $counter): never {
                throw new \RuntimeException(sprintf('Exception thrown %d times.', $counter));
            }));
        } catch (\RuntimeException $e) {
            $this->assertSame('Exception thrown 2 times.', $e->getMessage());
        }
    }
}
