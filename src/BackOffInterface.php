<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

interface BackOffInterface
{
    public function backOff(int $attempt, \Throwable $throwable): void;
}
