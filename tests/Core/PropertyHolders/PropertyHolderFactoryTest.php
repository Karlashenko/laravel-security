<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use Phrantiques\Security\Core\PropertyHolders\UserPropertyHolder;
use Phrantiques\Security\Core\PropertyHolders\PropertyHolderFactory;

class PropertyHolderFactoryTest extends TestCase
{
    public function testPropertyHolderFactoryCreatesProperties(): void
    {
        $user = new User();

        $property = PropertyHolderFactory::make($user);

        $this->assertInstanceOf(UserPropertyHolder::class, $property);
    }

    public function testPropertyHolderFactoryThrowsExceptionWhenClassNotFound(): void
    {
        $this->expectException(\Error::class);
        PropertyHolderFactory::make(new class() {});
    }
}
