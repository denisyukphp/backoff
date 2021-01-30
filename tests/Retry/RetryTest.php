<?php

namespace Orangesoft\Backoff\Tests\Retry;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Retry\RetryBuilder;
use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifier;

class RetryTest extends TestCase
{
    public function testRetrySignature(): void
    {
        $retry = (new RetryBuilder())->setMaxAttempts(1)->build();

        $args = [
            'value1',
            'value2',
        ];

        $callback = function (string $arg1, string $arg2) {
            $this->assertSame('value1', $arg1);
            $this->assertSame('value2', $arg2);
        };

        $retry->call($callback, $args);
    }

    public function testRetrySuccess(): void
    {
        $retry = (new RetryBuilder())->build();

        $result = $retry->call(function () {
            return 42;
        });

        $this->assertSame(42, $result);
    }

    public function testRetryFail(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \Exception::class,
        ]);

        $retry = (new RetryBuilder())
            ->setMaxAttempts(5)
            ->setExceptionClassifier($exceptionClassifier)
            ->build()
        ;

        $counter = 0;

        $this->expectException(\Exception::class);

        try {
            $retry->call(function () use (&$counter) {
                throw new \Exception('OK', $counter++);
            });
        } catch (\Exception $e) {
            $this->assertSame('OK', $e->getMessage());
            $this->assertSame(5, $e->getCode());

            throw $e;
        }
    }

    public function testSleepAttempts(): void
    {
        $sleepAttemptsCounter = new SleepAttemptsCounter();

        $exceptionClassifier = new ExceptionClassifier([
            \Exception::class,
        ]);

        $retry = (new RetryBuilder())
            ->setMaxAttempts(5)
            ->setExceptionClassifier($exceptionClassifier)
            ->setSleeper($sleepAttemptsCounter)
            ->build()
        ;

        try {
            $retry->call(function () {
                throw new \Exception();
            });
        } catch (\Exception $e) {
            $this->assertSame(4, $sleepAttemptsCounter->getAttemptsCount());
        }
    }
}
