<?php

namespace Orangesoft\BackOff\Tests\Retry\ExceptionClassifier;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Retry\ExceptionClassifier\ExceptionClassifier;

class ExceptionClassifierTest extends TestCase
{
    public function testDefaults(): void
    {
        $classifier = new ExceptionClassifier();

        $this->assertTrue($classifier->classify(new \Error()));
        $this->assertTrue($classifier->classify(new \Exception()));
    }

    public function testClassify(): void
    {
        $classifier = new ExceptionClassifier([
            \RuntimeException::class,
        ]);

        $this->assertTrue($classifier->classify(new \RuntimeException()));
        $this->assertTrue($classifier->classify(new \UnexpectedValueException()));
        $this->assertFalse($classifier->classify(new \InvalidArgumentException()));
        $this->assertFalse($classifier->classify(new \Exception()));
    }
}
