<?php

namespace Orangesoft\Backoff\Tests\Duration;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Comparator;
use Orangesoft\Backoff\Duration\Milliseconds;

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
