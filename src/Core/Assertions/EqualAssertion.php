<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Assertions;

class EqualAssertion implements Assertion
{
    /**
     * @inheritdoc
     */
    public function assert($valueA, $valueB): bool
    {
        return (string) $valueA === (string) $valueB;
    }
}
