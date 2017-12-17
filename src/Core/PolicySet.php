<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core;

use Phrantiques\Security\Core\Algorithms\Algorithm;

class PolicySet
{
    /**
     * @var Policy[]
     */
    private $policies;

    /**
     * @var Algorithm
     */
    private $algorithm;

    /**
     * Create a new PolicySet instance.
     *
     * @param Policy[] $policies
     */
    public function __construct(array $policies, Algorithm $algorithm)
    {
        $this->policies = $policies;
        $this->algorithm = $algorithm;
    }

    public function evaluate(): string
    {
        $results = [];

        foreach ($this->policies as $policy) {
            $results[] = $policy->evaluate();
        }

        return $this->algorithm->evaluate($results);
    }
}
