<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Algorithms\DenyOverrides;

class DenyOverridesTest extends TestCase
{
    public function testReturnsDenyWhenDenied(): void
    {
        $results = [
            Security::EVALUATION_EFFECT_PERMIT,
            Security::EVALUATION_EFFECT_NOT_APPLICABLE,
            Security::EVALUATION_EFFECT_DENY,
            Security::EVALUATION_EFFECT_INDETERMINATE,
        ];

        $algorithm = new DenyOverrides();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_DENY);
    }

    public function testReturnsPermitWhenNoOneDenied(): void
    {
        $results = [
            Security::EVALUATION_EFFECT_PERMIT,
            Security::EVALUATION_EFFECT_NOT_APPLICABLE,
            Security::EVALUATION_EFFECT_PERMIT,
            Security::EVALUATION_EFFECT_INDETERMINATE,
        ];

        $algorithm = new DenyOverrides();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_PERMIT);
    }

    public function testReturnsPermitWhenNoResults(): void
    {
        $results = [];

        $algorithm = new DenyOverrides();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_PERMIT);
    }
}
