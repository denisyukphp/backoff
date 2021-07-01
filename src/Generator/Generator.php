<?php

namespace Orangesoft\BackOff\Generator;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Strategy\StrategyInterface;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Duration\Comparator;
use Orangesoft\BackOff\Generator\Exception\MaxAttemptsException;

final class Generator implements GeneratorInterface
{
    /**
     * @var float
     */
    private $maxAttempts;
    /**
     * @var DurationInterface
     */
    private $baseTime;
    /**
     * @var DurationInterface
     */
    private $capTime;
    /**
     * @var StrategyInterface
     */
    private $strategy;
    /**
     * @var JitterInterface
     */
    private $jitter;

    public function __construct(GeneratorBuilder $builder)
    {
        $this->maxAttempts = $builder->getMaxAttempts();
        $this->baseTime = $builder->getBaseTime();
        $this->capTime = $builder->getCapTime();
        $this->strategy = $builder->getStrategy();
        $this->jitter = $builder->getJitter();
    }

    /**
     * @param int $attempt
     *
     * @return DurationInterface
     *
     * @throws MaxAttemptsException
     */
    public function generate(int $attempt): DurationInterface
    {
        if ($attempt >= $this->maxAttempts) {
            throw new MaxAttemptsException('Max attempts has been reached');
        }

        $sleepTime = $this->strategy->calculate($this->baseTime, $attempt);

        $comparator = new Comparator($this->capTime, $sleepTime);

        $duration = $comparator->getMin();

        return $this->jitter->jitter($duration);
    }
}
