<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry;

use Assert\Assertion;
use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Duration\Duration;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifierInterface;

final class BackOffRetry implements RetryInterface
{
    public function __construct(
        private int $maxAttempts,
        private Duration $baseTime,
        private Duration $capTime,
        private BackOffInterface $backOff,
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

            $this->backOff->backOff($attempt, $this->baseTime, $this->capTime);

            if ($attempt >= $this->maxAttempts || !$this->exceptionClassifier->classify($throwable)) {
                throw $throwable;
            }

            goto retrying;
        }
    }
}
