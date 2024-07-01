<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Sleeper;

use Orangesoft\BackOff\Duration\Duration;

/**
 * @codeCoverageIgnore
 */
final class CallbackSleeper implements SleeperInterface
{
    public function __construct(
        private \Closure $callback,
    ) {
    }

    public function sleep(Duration $sleepTime): void
    {
        ($this->callback)($sleepTime);
    }
}
