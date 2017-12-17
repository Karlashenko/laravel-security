<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\GreaterEqualAssertion;

class GreaterEqualAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new GreaterEqualAssertion();

        $this->assertTrue($assertion->assert(3, 2));
        $this->assertTrue($assertion->assert(3, 3));
        $this->assertFalse($assertion->assert('false', 2));
    }
}
