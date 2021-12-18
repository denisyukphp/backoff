<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\ImmediatelyThrowableBackOff;
use PHPUnit\Framework\TestCase;

class ImmediatelyThrowableBackOffTest extends TestCase
{
    public function testBackOff(): void
    {
        $immediatelyThrowableBackOff = new ImmediatelyThrowableBackOff();

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $immediatelyThrowableBackOff->backOff(1, $throwable);
    }
}
