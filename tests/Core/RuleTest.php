<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Rule;
use Phrantiques\Security\Core\Condition;
use Phrantiques\Security\Services\Security;

class RuleTest extends TestCase
{
    public function testRuleEvaluates(): void
    {
        $condition = new class extends Condition {
            public function check(): bool
            {
                return true;
            }
        };

        $rule = new Rule();
        $rule->setEffect(Security::EVALUATION_EFFECT_PERMIT);
        $rule->setCondition($condition);

        $this->assertEquals(Security::EVALUATION_EFFECT_PERMIT, $rule->evaluate());
    }
}
