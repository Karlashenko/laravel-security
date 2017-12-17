<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\LessEqualAssertion;

class LessEqualAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new LessEqualAssertion();

        $this->assertFalse($assertion->assert(3, 2));
        $this->assertTrue($assertion->assert(2, 3));
        $this->assertTrue($assertion->assert(3, 3));
        $this->assertTrue($assertion->assert('false', 2));
        $this->assertTrue($assertion->assert('false', 'false'));
        $this->assertFalse($assertion->assert(2, 'false'));
    }
}
