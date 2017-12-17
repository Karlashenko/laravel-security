<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Assertions\EqualAssertion;
use Phrantiques\Security\Core\Assertions\AssertionFactory;

class AssertionFactoryTest extends TestCase
{
    public function testAssertionCases(): void
    {
        $assertion = AssertionFactory::make(EqualAssertion::class);

        $this->assertInstanceOf(EqualAssertion::class, $assertion);
    }
}
