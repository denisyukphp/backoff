<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry\ExceptionClassifier;

final class ExceptionClassifier implements ExceptionClassifierInterface
{
    /**
     * @param string[] $classNames
     */
    public function __construct(
        private array $classNames = [],
    ) {
        if (0 === \count($classNames)) {
            $this->classNames = [
                \Error::class,
                \Exception::class,
            ];
        } else {
            foreach ($classNames as $className) {
                if (!class_exists($className) || !is_a($className, \Throwable::class, true)) {
                    throw new \InvalidArgumentException(vsprintf('Exception class must be a class that exists and can be thrown, "%s" given.', [get_debug_type($className)]));
                }

                $this->classNames[] = $className;
            }
        }
    }

    public function classify(\Throwable $throwable): bool
    {
        foreach ($this->classNames as $className) {
            if ($throwable instanceof $className) {
                return true;
            }
        }

        return false;
    }
}
