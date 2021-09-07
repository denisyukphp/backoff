<?php

namespace Orangesoft\BackOff\Tests\Retry\ExceptionClassifier;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;

class ExceptionClassifierTest extends TestCase
{
    public function testDefault(): void
    {
        $exceptionClassifier = new ExceptionClassifier();

        $this->assertTrue($exceptionClassifier->classify(new \Error()));
        $this->assertTrue($exceptionClassifier->classify(new \Exception()));
    }

    public function testInherited(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $this->assertTrue($exceptionClassifier->classify(new \RuntimeException()));
        $this->assertTrue($exceptionClassifier->classify(new \UnexpectedValueException()));
    }

    public function testUnsupported(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $this->assertFalse($exceptionClassifier->classify(new \InvalidArgumentException()));
        $this->assertFalse($exceptionClassifier->classify(new \Exception()));
    }
}
