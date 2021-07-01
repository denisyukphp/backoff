<?php

namespace Orangesoft\BackOff\Retry;

use Orangesoft\BackOff\BackOffInterface;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifierInterface;

final class Retry implements RetryInterface
{
    /**
     * @var BackOffInterface
     */
    private $backOff;
    /**
     * @var ExceptionClassifierInterface
     */
    private $classifier;

    public function __construct(BackOffInterface $backOff, ExceptionClassifierInterface $classifier)
    {
        $this->backOff = $backOff;
        $this->classifier = $classifier;
    }

    /**
     * @param callable $callback
     * @param mixed[] $args
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function call(callable $callback, array $args = [])
    {
        $attempt = 0;

        retrying:

        try {
            return $callback(...$args);
        } catch (\Throwable $throwable) {
            if (!$this->classifier->classify($throwable)) {
                throw $throwable;
            }

            $this->backOff->backOff($attempt, $throwable);

            $attempt++;

            goto retrying;
        }
    }
}
