<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Assertions;

class AssertionFactory
{
    /**
     * @param string $class
     *
     * @return Assertion
     */
    public static function make(string $class): Assertion
    {
        return new $class;
    }
}
