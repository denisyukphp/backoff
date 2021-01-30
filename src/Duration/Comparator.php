<?php

namespace Orangesoft\Backoff\Duration;

class Comparator
{
    /**
     * @var DurationInterface
     */
    private $a;
    /**
     * @var DurationInterface
     */
    private $b;

    public function __construct(DurationInterface $a, DurationInterface $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getMax(): DurationInterface
    {
        return $this->a->toNanoseconds() > $this->b->toNanoseconds() ? $this->a : $this->b;
    }

    public function getMin(): DurationInterface
    {
        return $this->a->toNanoseconds() > $this->b->toNanoseconds() ? $this->b : $this->a;
    }
}
