<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Generator;

use Orangesoft\BackOff\Duration\DurationInterface;

interface GeneratorInterface
{
    public function generate(int $attempt): DurationInterface;
}
