<?php

namespace Orangesoft\Backoff\Tests\Config;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Config\ConfigInterface;
use Orangesoft\Backoff\Jitter\EqualJitter;
use Orangesoft\Backoff\Jitter\JitterInterface;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Duration\DurationInterface;

class ConfigBuilderTest extends TestCase
{
    public function testCapTime(): void
    {
        $configBuilder = (new ConfigBuilder())->setCapTime(new Milliseconds(1000));

        $this->assertInstanceOf(DurationInterface::class, $configBuilder->getCapTime());
    }

    public function testMaxAttempts(): void
    {
        $configBuilder = (new ConfigBuilder())->setMaxAttempts(5);

        $this->assertEquals(5, $configBuilder->getMaxAttempts());
    }

    public function testDisabledJitter(): void
    {
        $configBuilder = new ConfigBuilder();

        $this->assertFalse($configBuilder->isJitterEnabled());
    }

    public function testEnabledJitter(): void
    {
        $configBuilder = (new ConfigBuilder())->enableJitter();

        $this->assertTrue($configBuilder->isJitterEnabled());
    }

    public function testJitter(): void
    {
        $configBuilder = (new ConfigBuilder())->setJitter(new EqualJitter());

        $this->assertInstanceOf(JitterInterface::class, $configBuilder->getJitter());
    }

    public function testBuild(): void
    {
        $config = (new ConfigBuilder())
            ->setCapTime(new Milliseconds(1000))
            ->setMaxAttempts(5)
            ->enableJitter()
            ->setJitter(new EqualJitter())
            ->build()
        ;

        $this->assertInstanceOf(ConfigInterface::class, $config);
    }
}
