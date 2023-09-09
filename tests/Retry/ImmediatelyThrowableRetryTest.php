<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\Retry\ImmediatelyThrowableRetry;
use PHPUnit\Framework\TestCase;

final class ImmediatelyThrowableRetryTest extends TestCase
{
    public function testImmediatelyThrowable(): void
    {
        $immediatelyThrowableRetry = new ImmediatelyThrowableRetry();

        $this->expectException(\RuntimeException::class);

        $immediatelyThrowableRetry->call(static function () {
            throw new \RuntimeException();
        });
    }
}
