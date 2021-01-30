<?php

namespace Orangesoft\Backoff\Retry;

use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifierInterface;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class Retry implements RetryInterface
{
    /**
     * @var int
     */
    private $maxAttempts;
    /**
     * @var ExceptionClassifierInterface
     */
    private $exceptionClassifier;
    /**
     * @var SleeperInterface
     */
    private $sleeper;

    public function __construct(RetryBuilder $retryBuilder)
    {
        $this->maxAttempts = $retryBuilder->getMaxAttempts();
        $this->exceptionClassifier = $retryBuilder->getExceptionClassifier();
        $this->sleeper = $retryBuilder->getSleeper();
    }

    /**
     * @param callable $callback
     * @param mixed[] $args
     *
     * @return mixed
     *
     * @throws
     */
    public function call(callable $callback, array $args = [])
    {
        $attempts = $this->maxAttempts;

        retrying:

        try {
            return $callback(...$args);
        } catch (\Throwable $e) {
            if (0 === $attempts || !$this->exceptionClassifier->classify($e)) {
                throw $e;
            }

            $this->sleeper->sleep($this->maxAttempts - $attempts);

            $attempts--;

            goto retrying;
        }
    }
}
