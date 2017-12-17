<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\GreaterAssertion;

class GreaterAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new GreaterAssertion();

        $this->assertTrue($assertion->assert(3, 2));
        $this->assertFalse($assertion->assert(2, 3));
        $this->assertFalse($assertion->assert('false', 2));
        $this->assertTrue($assertion->assert(2, 'false'));
    }
}
