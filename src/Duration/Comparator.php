<?php

namespace Orangesoft\BackOff\Duration;

final class Comparator
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
        return $this->a->asNanoseconds() > $this->b->asNanoseconds() ? $this->a : $this->b;
    }

    public function getMin(): DurationInterface
    {
        return $this->a->asNanoseconds() > $this->b->asNanoseconds() ? $this->b : $this->a;
    }
}
