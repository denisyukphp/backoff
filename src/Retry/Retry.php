<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry;

use Assert\Assertion;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifierInterface;

final class Retry implements RetryInterface
{
    public function __construct(
        private int $maxAttempts,
        private ExceptionClassifierInterface $exceptionClassifier,
    ) {
    }

    public function call(callable $callback): mixed
    {
        Assertion::greaterThan($this->maxAttempts, 0); // @codeCoverageIgnore

        $attempt = 0;

        retrying:

        try {
            return $callback();
        } catch (\Throwable $throwable) {
            ++$attempt;

            if ($attempt >= $this->maxAttempts || !$this->exceptionClassifier->classify($throwable)) {
                throw $throwable;
            }

            goto retrying;
        }
    }
}
