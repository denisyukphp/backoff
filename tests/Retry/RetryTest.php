<?php

namespace Orangesoft\BackOff\Tests\Retry;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Retry\Retry;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\BackOff\Facade\ConstantBackOff;

class RetryTest extends TestCase
{
    public function testReturnValue(): void
    {
        $retry = new Retry(
            new ConstantBackOff(3, 1000),
            new ExceptionClassifier()
        );

        $callback = function (int $a, int $b): int {
            return $a + $b;
        };

        $args = [5, 10];

        $result = $retry->call($callback, $args);

        $this->assertSame(15, $result);
    }

    public function testThrowException(): void
    {
        $backOff = new ConstantBackOff(0, 0);

        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $retry = new Retry($backOff, $exceptionClassifier);

        $this->expectException(\RuntimeException::class);

        $retry->call(function () {
            throw new \RuntimeException();
        });
    }

    public function testAttemptsCounter(): void
    {
        $attemptsCounter = new AttemptsCounter(3);

        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $retry = new Retry($attemptsCounter, $exceptionClassifier);

        try {
            $retry->call(function () {
                throw new \RuntimeException();
            });
        } catch (\RuntimeException $e) {
            $this->assertSame(3, $attemptsCounter->getLastAttempt());
        }
    }
}
