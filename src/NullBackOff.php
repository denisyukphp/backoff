<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

/**
 * @codeCoverageIgnore
 */
final class NullBackOff implements BackOffInterface
{
    public function backOff(int $attempt): void
    {
    }
}
