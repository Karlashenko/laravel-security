<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Assertions;

interface Assertion
{
    /**
     * @param mixed $valueA
     * @param mixed $valueB
     *
     * @return bool
     */
    public function assert($valueA, $valueB): bool;
}
