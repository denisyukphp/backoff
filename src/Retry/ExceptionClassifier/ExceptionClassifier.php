<?php

namespace Orangesoft\BackOff\Retry\ExceptionClassifier;

final class ExceptionClassifier implements ExceptionClassifierInterface
{
    /**
     * @var string[]
     */
    private $exceptionClasses;

    /**
     * @param string[] $exceptionClasses
     */
    public function __construct(array $exceptionClasses = [])
    {
        if (0 === count($exceptionClasses)) {
            $exceptionClasses = [
                \Error::class,
                \Exception::class,
            ];
        }

        foreach ($exceptionClasses as $exceptionClass) {
            $this->add($exceptionClass);
        }
    }

    private function add(string $exceptionClass): void
    {
        if (!class_exists($exceptionClass) || !is_a($exceptionClass, \Throwable::class, true)) {
            throw new \InvalidArgumentException(
                sprintf('Exception class must be a class that exists and can be thrown, "%s" given.', get_debug_type($exceptionClass))
            );
        }

        $this->exceptionClasses[] = $exceptionClass;
    }

    public function classify(\Throwable $throwable): bool
    {
        foreach ($this->exceptionClasses as $exceptionClass) {
            if ($throwable instanceof $exceptionClass) {
                return true;
            }
        }

        return false;
    }
}
