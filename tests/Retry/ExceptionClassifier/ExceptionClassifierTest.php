<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry\ExceptionClassifier;

use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use PHPUnit\Framework\TestCase;

final class ExceptionClassifierTest extends TestCase
{
    /**
     * @param string[] $classNames
     *
     * @dataProvider getClassifyData
     */
    public function testClassify(array $classNames, \Throwable $throwable, bool $expectedResult): void
    {
        $exceptionClassifier = new ExceptionClassifier($classNames);

        $actualResult = $exceptionClassifier->classify($throwable);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function getClassifyData(): array
    {
        return [
            [[], new \Error(), true],
            [[], new \Exception(), true],
            [[], new \RuntimeException(), true],
            [[\RuntimeException::class], new \RuntimeException(), true],
            [[\RuntimeException::class], new \UnexpectedValueException(), true],
            [[\RuntimeException::class], new \InvalidArgumentException(), false],
        ];
    }
}
