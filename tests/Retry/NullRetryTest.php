<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry;

use Orangesoft\BackOff\Retry\NullRetry;
use PHPUnit\Framework\TestCase;

final class NullRetryTest extends TestCase
{
    public function testImmediatelyThrowable(): void
    {
        $retry = new NullRetry();

        $this->expectException(\RuntimeException::class);

        $retry->call(static function (): never {
            throw new \RuntimeException();
        });
    }
}
