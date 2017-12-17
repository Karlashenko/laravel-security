<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\NotEqualAssertion;

class NotEqualAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new NotEqualAssertion();

        $this->assertFalse($assertion->assert(1, '1'));
        $this->assertTrue($assertion->assert(2, '1'));
    }
}
