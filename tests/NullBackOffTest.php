<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\NullBackOff;
use PHPUnit\Framework\TestCase;

class NullBackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $nullBackOff = new NullBackOff(maxAttempts: 3);

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $nullBackOff->backOff(4, $throwable);
    }
}
