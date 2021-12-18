<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

class ImmediatelyThrowableBackOff implements BackOffInterface
{
    public function backOff(int $attempt, \Throwable $throwable): void
    {
        throw $throwable;
    }
}
