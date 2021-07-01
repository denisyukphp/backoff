<?php

namespace Orangesoft\BackOff\Retry\ExceptionClassifier;

interface ExceptionClassifierInterface
{
    public function classify(\Throwable $throwable): bool;
}
