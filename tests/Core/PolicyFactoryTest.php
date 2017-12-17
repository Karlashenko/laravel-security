<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use App\Models\Callings\Calling;
use Phrantiques\Security\Models\Rule;
use Phrantiques\Security\Models\Policy;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\PolicyFactory;
use Phrantiques\Security\Core\Assertions\EqualAssertion;
use Phrantiques\Security\Core\Algorithms\PermitUnlessDeny;

class PolicyFactoryTest extends TestCase
{
    public function testPolicyFactory(): void
    {
        $condition = [
            'assertion' => EqualAssertion::class,
            'propertyA' => [
                'type'   => Security::PROPERTY_TYPE_SUBJECT,
                'entity' => User::class,
                'key'    => 'id',
                'value'  => '',
            ],
            'propertyB' => [
                'type'   => Security::PROPERTY_TYPE_RESOURCE,
                'entity' => Calling::class,
                'key'    => 'id',
                'value'  => '',
            ],
        ];

        $rule = new Rule();
        $rule->condition = $condition;
        $rule->effect = Security::EVALUATION_EFFECT_DENY;

        $model = new Policy();
        $model->id = 1;
        $model->algorithm = PermitUnlessDeny::class;
        $model->action = Security::ACTION_DELETE;
        $model->subject = User::class;
        $model->resource = Calling::class;
        $model->setRelation('rules', collect([$rule, $rule]));

        $user = new User();
        $calling = new Calling();

        $policy = PolicyFactory::make($model, $user, $calling);

        $this->assertInstanceOf(\Phrantiques\Security\Core\Policy::class, $policy);
    }
}
