<?php

declare(strict_types=1);

use Phrantiques\Security\Core\Assertions\ContainsAllAssertion;
use Tests\TestCase;

class ContainsAllAssertionTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = new ContainsAllAssertion();

        $this->assertFalse($assertion->assert('foo, bar', 'foo, foo, baz'));
        $this->assertFalse($assertion->assert(['foo', 'bar'], ['foo', 'baz', 'baz']));

        $this->assertTrue($assertion->assert('foo, bar', 'foo, bar'));
        $this->assertTrue($assertion->assert(['foo', 'bar'], ['foo', 'bar']));
    }
}
