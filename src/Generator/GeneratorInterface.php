<?php

namespace Orangesoft\BackOff\Generator;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Generator\Exception\MaxAttemptsException;

interface GeneratorInterface
{
    /**
     * @param int $attempt
     *
     * @return DurationInterface
     *
     * @throws MaxAttemptsException
     */
    public function generate(int $attempt): DurationInterface;
}
