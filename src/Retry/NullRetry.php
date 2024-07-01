<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry;

final class NullRetry implements RetryInterface
{
    public function call(callable $callback): mixed
    {
        return $callback();
    }
}
