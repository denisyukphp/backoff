<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Retry\ExceptionClassifier;

final class ExceptionClassifier implements ExceptionClassifierInterface
{
    /**
     * @var string[]
     */
    private array $classNames = [];

    /**
     * @param string[] $classNames
     */
    public function __construct(array $classNames = [])
    {
        if (0 !== \count($classNames)) {
            foreach ($classNames as $className) {
                $this->add($className);
            }
        } else {
            $this->classNames = [
                \Error::class,
                \Exception::class,
            ];
        }
    }

    private function add(string $className): void
    {
        if (!class_exists($className) || !is_a($className, \Throwable::class, true)) {
            throw new \InvalidArgumentException(sprintf('Exception class must be a class that exists and can be thrown, "%s" given.', get_debug_type($className))); // @codeCoverageIgnore
        }

        $this->classNames[] = $className;
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
