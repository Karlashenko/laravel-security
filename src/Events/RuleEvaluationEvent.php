<?php

declare(strict_types=1);

namespace Phrantiques\Security\Events;

use Phrantiques\Security\Core\Rule;

class RuleEvaluationEvent
{
    /**
     * @var Rule
     */
    private $rule;

    /**
     * @var string
     */
    private $effect;

    /**
     * Create a new RuleEvaluationEvent instance.
     *
     * @param Rule   $rule
     * @param string $effect
     */
    public function __construct(Rule $rule, string $effect)
    {
        $this->rule = $rule;
        $this->effect = $effect;
    }

    /**
     * @return Rule
     */
    public function getRule(): Rule
    {
        return $this->rule;
    }

    /**
     * @return string
     */
    public function getEffect(): string
    {
        return $this->effect;
    }
}
