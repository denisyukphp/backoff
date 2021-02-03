<?php

namespace Orangesoft\Backoff\Retry\ExceptionClassifier;

class ExceptionClassifier implements ExceptionClassifierInterface
{
    /**
     * @var string[]
     */
    private $exceptionTypes = [];

    /**
     * @param string[] $exceptionTypes
     */
    public function __construct(array $exceptionTypes = [])
    {
        foreach ($exceptionTypes as $exceptionType) {
            $this->addExceptionType($exceptionType);
        }
    }

    private function addExceptionType(string $exceptionType): void
    {
        if (!class_exists($exceptionType) || !is_a($exceptionType, \Throwable::class, true)) {
            throw new \InvalidArgumentException(
                sprintf('Exception type %s is invalid', $exceptionType)
            );
        }

        $this->exceptionTypes[] = $exceptionType;
    }

    public function classify(\Throwable $e): bool
    {
        foreach ($this->exceptionTypes as $exceptionType) {
            if ($e instanceof $exceptionType) {
                return true;
            }
        }

        return false;
    }
}
