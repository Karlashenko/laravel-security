<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Assertions;

class ContainsAllAssertion implements Assertion
{
    /**
     * @inheritdoc
     */
    public function assert($valueA, $valueB): bool
    {
        if (!is_array($valueA)) {
            $valueA = explode(',', $valueA);
        }

        if (!is_array($valueB)) {
            $valueB = explode(',', $valueB);
        }

        $valueA = array_map('trim', $valueA);
        $valueB = array_map('trim', $valueB);

        $valueA = array_unique(array_filter($valueA));
        $valueB = array_unique(array_filter($valueB));

        return count(array_intersect($valueB, $valueA)) === count($valueB);
    }
}
