<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Algorithms\PermitUnlessDeny;

class PermitUnlessDenyTest extends TestCase
{
    public function testReturnsPermitWhenNoOneDenied(): void
    {
        $results = [
            Security::EVALUATION_EFFECT_PERMIT,
            Security::EVALUATION_EFFECT_NOT_APPLICABLE,
            Security::EVALUATION_EFFECT_INDETERMINATE,
        ];

        $algorithm = new PermitUnlessDeny();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_PERMIT);
    }

    public function testReturnsDenyWhenSomeOneDenied(): void
    {
        $results = [
            Security::EVALUATION_EFFECT_DENY,
            Security::EVALUATION_EFFECT_INDETERMINATE,
        ];

        $algorithm = new PermitUnlessDeny();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_DENY);
    }

    public function testReturnsPermitWhenNoResults(): void
    {
        $results = [];

        $algorithm = new PermitUnlessDeny();
        $decision = $algorithm->evaluate($results);

        $this->assertSame($decision, Security::EVALUATION_EFFECT_PERMIT);
    }
}
