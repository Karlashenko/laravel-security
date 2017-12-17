<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\LessAssertion;

class LessAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new LessAssertion();

        $this->assertFalse($assertion->assert(3, 2));
        $this->assertTrue($assertion->assert(2, 3));
        $this->assertTrue($assertion->assert('false', 2));
        $this->assertFalse($assertion->assert(2, 'false'));
    }
}
