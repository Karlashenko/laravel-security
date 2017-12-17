<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core;

use Phrantiques\Security\Core\Algorithms\Algorithm;

class Policy
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var mixed
     */
    private $resource;

    /**
     * @var Algorithm
     */
    private $algorithm;

    /**
     * @var Rule[]
     */
    private $rules;

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction(string $action): Policy
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     *
     * @return $this
     */
    public function setSubject($subject): Policy
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     *
     * @return $this
     */
    public function setResource($resource): Policy
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return Algorithm
     */
    public function getAlgorithm(): Algorithm
    {
        return $this->algorithm;
    }

    /**
     * @param Algorithm $algorithm
     *
     * @return $this
     */
    public function setAlgorithm(Algorithm $algorithm): Policy
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param Rule[] $rules
     *
     * @return $this
     */
    public function setRules(array $rules): Policy
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @return string
     */
    public function evaluate(): string
    {
        $results = [];

        foreach ($this->getRules() as $rule) {
            $results[] = $rule->evaluate();
        }

        return $this->getAlgorithm()->evaluate($results);
    }
}
