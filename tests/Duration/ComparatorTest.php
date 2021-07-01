<?php

namespace Orangesoft\BackOff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Duration\Comparator;
use Orangesoft\BackOff\Duration\Milliseconds;

class ComparatorTest extends TestCase
{
    public function testMax(): void
    {
        $a = new Milliseconds(1000);
        $b = new Milliseconds(2000);

        $comparator = new Comparator($a, $b);

        $this->assertSame($b, $comparator->getMax());
    }

    public function testMin(): void
    {
        $a = new Milliseconds(1000);
        $b = new Milliseconds(2000);

        $comparator = new Comparator($a, $b);

        $this->assertSame($a, $comparator->getMin());
    }
}
