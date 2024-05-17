<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Generator;

interface GeneratorInterface
{
    public function generate(int $attempt, float $baseTime, float $capTime): float;
}
