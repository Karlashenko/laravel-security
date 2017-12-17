<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Algorithms;

interface Algorithm
{
    /**
     * @param string[] $results
     *
     * @return string
     */
    public function evaluate(array $results): string;
}
