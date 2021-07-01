<?php

namespace Orangesoft\BackOff;

interface BackOffInterface
{
    /**
     * @param int $attempt
     * @param \Throwable $throwable
     *
     * @throws \Throwable
     */
    public function backOff(int $attempt, \Throwable $throwable): void;
}
