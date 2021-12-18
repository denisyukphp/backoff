<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry;

interface RetryInterface
{
    public function call(callable $callback, array $args = []): mixed;
}
