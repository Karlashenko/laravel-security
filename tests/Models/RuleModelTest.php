<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use Phrantiques\Security\Models\Rule;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Assertions\EqualAssertion;

class RuleModelTest extends TestCase
{
    public function testPoliciesRelation(): void
    {
        $rule = new Rule();
        $rule->id = 1;
        $rule->policies()->get();
    }

    public function testGetConditionAsString(): void
    {
        $rule = new Rule();

        $rule->condition = [
            'assertion' => EqualAssertion::class,
            'propertyA' => [
                'type'   => Security::PROPERTY_TYPE_SUBJECT,
                'entity' => User::class,
                'key'    => 'id',
                'value'  => '',
            ],
            'propertyB' => [
                'type'   => Security::PROPERTY_TYPE_RAW,
                'value'  => ['One', 'Two'],
            ],
        ];

        $rule->getConditionAsString();
    }
}
