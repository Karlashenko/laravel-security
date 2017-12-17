<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\ContainsAnyAssertion;

class ContainsAnyAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new ContainsAnyAssertion();

        $this->assertTrue($assertion->assert('foo, bar', 'foo, baz'));
        $this->assertTrue($assertion->assert(['foo', 'bar'], ['foo', 'baz']));

        $this->assertFalse($assertion->assert('foo, bar', 'baz, xyz'));
        $this->assertFalse($assertion->assert(['foo', 'bar'], ['baz', 'xyz']));
    }
}
