<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry\ExceptionClassifier;

interface ExceptionClassifierInterface
{
    public function classify(\Throwable $throwable): bool;
}
