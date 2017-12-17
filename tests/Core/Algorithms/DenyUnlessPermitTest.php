<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Algorithms\DenyUnlessPermit;

class DenyUnlessPermitTest extends TestCase
{
    public function testReturnsPermitWhenPermitted(): void
    {
        $results = [
            Security::EVALUATION_EFFECT_PERMIT,
            Security::EVALUATION_EFFECT_NOT_APPLICABLE,
            Security::EVALUATION_EFFECT_DENY,
            Security::EVALUATION_EFFECT_INDETERMINATE,
        ];

        $algorithm = new DenyUnlessPermit();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_PERMIT);
    }

    public function testReturnsDenyWhenNoOnePermitted(): void
    {
        $results = [
            Security::EVALUATION_EFFECT_DENY,
            Security::EVALUATION_EFFECT_INDETERMINATE,
        ];

        $algorithm = new DenyUnlessPermit();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_DENY);
    }

    public function testReturnsDenyWhenNoResults(): void
    {
        $results = [];

        $algorithm = new DenyUnlessPermit();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_DENY);
    }
}
