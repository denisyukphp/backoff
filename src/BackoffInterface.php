<?php

namespace Orangesoft\Backoff;

use Orangesoft\Backoff\Duration\DurationInterface;

interface BackoffInterface
{
    public function generate(int $attempt): DurationInterface;
}
