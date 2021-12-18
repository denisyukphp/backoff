<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry;

use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifierInterface;

final class Retry implements RetryInterface
{
    public function __construct(
        private BackOffInterface $backOff,
        private ExceptionClassifierInterface $exceptionClassifier,
    ) {
    }

    public function call(callable $callback, array $args = []): mixed
    {
        $attempt = 1;

        retrying:

        try {
            return $callback(...$args);
        } catch (\Throwable $throwable) {
            if (!$this->exceptionClassifier->classify($throwable)) {
                throw $throwable;
            }

            $this->backOff->backOff($attempt, $throwable);

            $attempt++;

            goto retrying;
        }
    }
}
