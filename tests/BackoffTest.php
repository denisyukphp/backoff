<?php

namespace Orangesoft\Backoff\Tests;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Strategy\LinearStrategy;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Jitter\EqualJitter;
use Orangesoft\Backoff\Exception\LimitedAttemptsException;
use Orangesoft\Backoff\Backoff;

class BackoffTest extends TestCase
{
    public function testMaxAttemptsSuccess(): void
    {
        $strategy = new LinearStrategy(new Milliseconds(1000));

        $config = (new ConfigBuilder())->setMaxAttempts(5)->build();

        $backoff = new Backoff($strategy, $config);

        $backoffTime = $backoff->generate(4);

        $this->assertEquals(5000, $backoffTime->asMilliseconds());
    }

    public function testMaxAttemptsFail(): void
    {
        $strategy = new LinearStrategy(new Milliseconds(1000));

        $config = (new ConfigBuilder())->setMaxAttempts(5)->build();

        $backoff = new Backoff($strategy, $config);

        $this->expectException(LimitedAttemptsException::class);

        $backoff->generate(5);
    }

    public function testCapTime(): void
    {
        $strategy = new LinearStrategy(new Milliseconds(1000 * 60));

        $config = (new ConfigBuilder())->setCapTime(new Milliseconds(1000 * 60))->build();

        $backoff = new Backoff($strategy, $config);

        $backoffTime = $backoff->generate(1);

        $this->assertEquals(1000 * 60, $backoffTime->asMilliseconds());
    }

    public function testJitterTime(): void
    {
        $strategy = new LinearStrategy(new Milliseconds(1000));

        $config = (new ConfigBuilder())
            ->setJitter(new EqualJitter())
            ->build()
        ;

        $backoff = new Backoff($strategy, $config);

        $backoffTime = $backoff->generate(4);

        $this->assertNotEquals(4000, $backoffTime->asMilliseconds());
    }
}
