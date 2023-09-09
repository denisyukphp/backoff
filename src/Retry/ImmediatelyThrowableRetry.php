<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry;

final class ImmediatelyThrowableRetry implements RetryInterface
{
    public function call(callable $callback): mixed
    {
        return $callback();
    }
}
