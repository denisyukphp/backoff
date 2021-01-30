<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\BackoffFactory;
use Orangesoft\Backoff\BackoffInterface;

class BackoffFactoryTest extends TestCase
{
    public function testLinearBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getLinearBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }

    public function testLinearFullJitterBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getLinearFullJitterBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }

    public function testLinearEqualJitterBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getLinearEqualJitterBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }

    public function testExponentialBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getExponentialBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }

    public function testExponentialFullJitterBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getExponentialFullJitterBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }

    public function testExponentialEqualJitterBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getExponentialEqualJitterBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }

    public function testDecorrelationJitterBackoff(): void
    {
        $factory = new BackoffFactory();

        $backoff = $factory->getDecorrelationJitterBackoff(new Milliseconds(1000));

        $this->assertInstanceOf(BackoffInterface::class, $backoff);
    }
}
