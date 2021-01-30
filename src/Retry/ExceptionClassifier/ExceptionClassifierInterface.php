<?php

namespace Orangesoft\Backoff\Retry\ExceptionClassifier;

interface ExceptionClassifierInterface
{
    public function classify(\Throwable $e): bool;
}
