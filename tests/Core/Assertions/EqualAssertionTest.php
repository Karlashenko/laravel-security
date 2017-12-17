<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\EqualAssertion;

class EqualAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new EqualAssertion();

        $this->assertTrue($assertion->assert(1, '1'));
        $this->assertFalse($assertion->assert('false', 'true'));
    }
}
