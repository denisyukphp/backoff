<?php

namespace Orangesoft\Backoff\Tests\Retry;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Retry\RetryBuilder;
use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifier;
use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifierInterface;
use Orangesoft\Backoff\Sleeper\DummySleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;
use Orangesoft\Backoff\Retry\RetryInterface;

class RetryBuilderTest extends TestCase
{
    public function testMaxAttempts(): void
    {
        $retryBuilder = (new RetryBuilder())->setMaxAttempts(5);

        $this->assertSame(5, $retryBuilder->getMaxAttempts());
    }

    public function testExceptionClassifier(): void
    {
        $retryBuilder = (new RetryBuilder())->setExceptionClassifier(new ExceptionClassifier());

        $this->assertInstanceOf(ExceptionClassifierInterface::class, $retryBuilder->getExceptionClassifier());
    }

    public function testSleeper(): void
    {
        $retryBuilder = (new RetryBuilder())->setSleeper(new DummySleeper());

        $this->assertInstanceOf(SleeperInterface::class, $retryBuilder->getSleeper());
    }

    public function testBuild(): void
    {
        $retryBuilder = (new RetryBuilder())
            ->setMaxAttempts(5)
            ->setExceptionClassifier(new ExceptionClassifier())
            ->setSleeper(new DummySleeper())
        ;

        $this->assertInstanceOf(RetryInterface::class, $retryBuilder->build());
    }
}
