<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core;

use Illuminate\Support\Facades\Event;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Events\RuleEvaluationEvent;

class Rule
{
    /**
     * @var string
     */
    private $effect;

    /**
     * @var Condition
     */
    private $condition;

    /**
     * @param string $effect
     *
     * @return $this
     */
    public function setEffect(string $effect)
    {
        $this->effect = $effect;

        return $this;
    }

    /**
     * @param Condition $condition
     *
     * @return $this
     */
    public function setCondition(Condition $condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return bool
     */
    public function evaluate(): string
    {
        $effect = $this->condition->check() ? $this->effect : Security::EVALUATION_EFFECT_NOT_APPLICABLE;

        Event::fire(Security::EVENT_RULE_EVALUATION, new RuleEvaluationEvent($this, $effect));

        return $effect;
    }
}
