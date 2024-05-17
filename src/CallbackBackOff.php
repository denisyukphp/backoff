<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Duration\Duration;

/**
 * @codeCoverageIgnore
 */
final class CallbackBackOff implements BackOffInterface
{
    public function __construct(
        private \Closure $callback,
    ) {
    }

    public function backOff(int $attempt, Duration $baseTime, Duration $capTime): void
    {
        ($this->callback)($attempt, $baseTime, $capTime);
    }
}
