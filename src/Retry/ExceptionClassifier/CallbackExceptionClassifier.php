<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry\ExceptionClassifier;

/**
 * @codeCoverageIgnore
 */
final class CallbackExceptionClassifier implements ExceptionClassifierInterface
{
    public function __construct(
        private \Closure $callback,
    ) {
    }

    public function classify(\Throwable $throwable): bool
    {
        $result = ($this->callback)($throwable);

        if (!\is_bool($result)) {
            throw new \RuntimeException(\sprintf('Callback must return bool, %s given.', get_debug_type($result)));
        }

        return $result;
    }
}
