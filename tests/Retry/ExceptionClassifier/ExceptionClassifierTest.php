<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Retry\ExceptionClassifier;

use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;
use PHPUnit\Framework\TestCase;

class ExceptionClassifierTest extends TestCase
{
    public function testDefaultExceptions(): void
    {
        $exceptionClassifier = new ExceptionClassifier();

        $this->assertTrue($exceptionClassifier->classify(new \Error()));
        $this->assertTrue($exceptionClassifier->classify(new \Exception()));
    }

    public function testInheritedException(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $this->assertTrue($exceptionClassifier->classify(new \UnexpectedValueException()));
    }

    public function testSupportedException(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $this->assertTrue($exceptionClassifier->classify(new \RuntimeException()));
    }

    public function testUnsupportedException(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $this->assertFalse($exceptionClassifier->classify(new \InvalidArgumentException()));
    }

    public function testInvalidClassName(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new ExceptionClassifier([
            \stdClass::class,
        ]);
    }
}
