<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

/**
 * @codeCoverageIgnore
 */
final class CallbackBackOff implements BackOffInterface
{
    public function __construct(
        private \Closure $callback,
    ) {
    }

    public function backOff(int $attempt): void
    {
        ($this->callback)($attempt);
    }
}
