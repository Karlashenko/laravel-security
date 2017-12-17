<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use App\Models\Callings\Calling;
use Phrantiques\Security\Core\Condition;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Assertions\EqualAssertion;
use Phrantiques\Security\Core\Hydrators\ConditionHydrator;

class ConditionHydratorTest extends TestCase
{
    public function testConditionHydratorWithRawDataValue(): void
    {
        $user = new User();
        $user->id = 228;

        $hydrator = new ConditionHydrator($user, new Calling());
        $condition = new Condition();

        $data = [
            'assertion' => EqualAssertion::class,
            'propertyA' => [
                'type'   => Security::PROPERTY_TYPE_SUBJECT,
                'entity' => User::class,
                'key'    => 'id',
            ],
            'propertyB' => [
                'type'   => Security::PROPERTY_TYPE_RAW,
                'value'  => 'RAW',
            ],
        ];

        $hydrator->hydrate($data, $condition);

        $this->assertInstanceOf(EqualAssertion::class, $condition->getAssertion());
        $this->assertEquals(228, $condition->getPropertyA()->getValue());
        $this->assertEquals('RAW', $condition->getPropertyB()->getValue());
        $this->assertFalse($condition->check());
    }

    public function testConditionHydratorWithResourceDataValue(): void
    {
        $user = new User();
        $user->id = 228;

        $calling = new Calling();
        $calling->id = 228;

        $hydrator = new ConditionHydrator($user, $calling);
        $condition = new Condition();

        $data = [
            'assertion' => EqualAssertion::class,
            'propertyA' => [
                'type'   => Security::PROPERTY_TYPE_SUBJECT,
                'entity' => User::class,
                'key'    => 'id',
            ],
            'propertyB' => [
                'type'   => Security::PROPERTY_TYPE_RESOURCE,
                'entity' => Calling::class,
                'key'    => 'id',
            ],
        ];

        $hydrator->hydrate($data, $condition);

        $this->assertInstanceOf(EqualAssertion::class, $condition->getAssertion());
        $this->assertEquals(228, $condition->getPropertyA()->getValue());
        $this->assertEquals(228, $condition->getPropertyB()->getValue());
        $this->assertTrue($condition->check());
    }

    public function testConditionHydratorChecksConditionData(): void
    {
        $this->expectException(\RuntimeException::class);

        $data = [
            'propertyA' => [],
            'propertyB' => [],
        ];

        $hydrator = new ConditionHydrator(new User(), new Calling());
        $hydrator->hydrate($data, new Condition());
    }

    public function testConditionHydratorChecksDataKeys(): void
    {
        $this->expectException(\RuntimeException::class);

        $data = [
            'assertion' => EqualAssertion::class,
            'propertyA' => [
                'type'   => Security::PROPERTY_TYPE_SUBJECT,
                'key'    => 'id',
            ],
            'propertyB' => [
                'type'   => Security::PROPERTY_TYPE_RESOURCE,
                'entity' => User::class,
                'key'    => 'id',
            ],
        ];

        $hydrator = new ConditionHydrator(new User(), new Calling());
        $hydrator->hydrate($data, new Condition());
    }

    public function testConditionHydratorChecksPropertyTypeExists(): void
    {
        $this->expectException(\RuntimeException::class);

        $data = [
            'assertion' => EqualAssertion::class,
            'propertyA' => [
                'type'   => 'unknown',
                'entity' => User::class,
                'key'    => 'id',
            ],
            'propertyB' => [
                'type'   => Security::PROPERTY_TYPE_RESOURCE,
                'entity' => User::class,
                'key'    => 'id',
            ],
        ];

        $hydrator = new ConditionHydrator(new User(), new Calling());
        $hydrator->hydrate($data, new Condition());
    }
}
