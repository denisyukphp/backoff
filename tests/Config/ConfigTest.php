<?php

namespace Orangesoft\Backoff\Tests\Config;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Config\Config;
use Orangesoft\Backoff\Config\ConfigBuilder;
use Orangesoft\Backoff\Jitter\EqualJitter;
use Orangesoft\Backoff\Jitter\JitterInterface;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Duration\DurationInterface;

class ConfigTest extends TestCase
{
    public function testCapTime(): void
    {
        $builder = (new ConfigBuilder())->setCapTime(new Milliseconds(1000));

        $config = new Config($builder);

        $this->assertInstanceOf(DurationInterface::class, $config->getCapTime());
    }

    public function testMaxAttempts(): void
    {
        $builder = (new ConfigBuilder())->setMaxAttempts(5);

        $config = new Config($builder);

        $this->assertEquals(5, $config->getMaxAttempts());
    }

    public function testDisabledJitter(): void
    {
        $config = new Config(new ConfigBuilder());

        $this->assertFalse($config->isJitterEnabled());
    }

    public function testEnabledJitter(): void
    {
        $builder = (new ConfigBuilder())->enableJitter();

        $config = new Config($builder);

        $this->assertTrue($config->isJitterEnabled());
    }

    public function testJitter(): void
    {
        $builder = (new ConfigBuilder())->setJitter(new EqualJitter());

        $config = new Config($builder);

        $this->assertInstanceOf(JitterInterface::class, $config->getJitter());
    }
}
