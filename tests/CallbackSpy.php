<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

final class CallbackSpy
{
    private int $counter = 0;

    public function __construct(
        private \Closure $callback,
    ) {
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function __invoke(): void
    {
        ($this->callback)($this->counter++);
    }
}
