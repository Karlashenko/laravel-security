<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use Phrantiques\Security\Models\Policy;
use Phrantiques\Security\Support\Config;
use Phrantiques\Security\Services\Security;

class PolicyModelTest extends TestCase
{
    public function testGetPropertiesAsString(): void
    {
        $properties = Config::getEntityProperties(Security::PROPERTY_TYPE_RESOURCE, User::class);

        $rule = new Policy();
        $rule->resource = User::class;
        $rule->properties = array_keys($properties);
        $rule->getPropertiesAsString();
    }
}
