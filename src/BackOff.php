<?php

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Generator\GeneratorInterface;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Generator\Exception\MaxAttemptsException;

final class BackOff implements BackOffInterface
{
    /**
     * @var GeneratorInterface
     */
    private $generator;
    /**
     * @var SleeperInterface
     */
    private $sleeper;

    public function __construct(GeneratorInterface $generator, SleeperInterface $sleeper)
    {
        $this->generator = $generator;
        $this->sleeper = $sleeper;
    }

    /**
     * @param int $attempt
     * @param \Throwable $throwable
     *
     * @throws \Throwable
     */
    public function backOff(int $attempt, \Throwable $throwable): void
    {
        try {
            $duration = $this->generator->generate($attempt);
        } catch (MaxAttemptsException $e) {
            throw $throwable;
        }

        $this->sleeper->sleep($duration);
    }
}
