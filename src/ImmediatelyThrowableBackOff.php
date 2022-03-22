<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

final class ImmediatelyThrowableBackOff implements BackOffInterface
{
    public function backOff(int $attempt, \Throwable $throwable): void
    {
        throw $throwable;
    }
}
