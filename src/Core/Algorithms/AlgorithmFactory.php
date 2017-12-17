<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Algorithms;

class AlgorithmFactory
{
    /**
     * @param string $class
     *
     * @return Algorithm
     */
    public static function make(string $class): Algorithm
    {
        return new $class();
    }
}
