<?php

namespace Orangesoft\Backoff\Tests\Retry\ExceptionClassifier;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Retry\ExceptionClassifier\ExceptionClassifier;

class ExceptionClassifierTest extends TestCase
{
    public function testClassifySuccess(): void
    {
        $exceptionClassifier = new ExceptionClassifier([
            \Exception::class,
        ]);

        $this->assertTrue($exceptionClassifier->classify(new \Exception()));
    }

    public function testClassifyFail(): void
    {
        $exceptionClassifier = new ExceptionClassifier();

        $this->assertFalse($exceptionClassifier->classify(new \Exception()));
    }
}
