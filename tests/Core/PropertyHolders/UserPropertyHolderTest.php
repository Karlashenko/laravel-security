<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use Phrantiques\Security\Core\PropertyHolders\UserPropertyHolder;

class UserPropertyHolderTest extends TestCase
{
    public function testCallingPropertyHolder(): void
    {
        $roles = collect([
            new \App\Models\Role(['name' => 'root']),
            new \App\Models\Role(['name' => 'admin']),
        ]);

        $user = new User();
        $user->id = 1;
        $user->email = 'user@mail.com';
        $user->login = 'user';
        $user->fio = 'User User User';
        $user->phone = '1-11-111-1111';
        $user->id_prov = 2;
        $user->setRelation('roles', $roles);

        $propertyHolder = new UserPropertyHolder($user);

        $this->assertEquals($user->id, $propertyHolder->getProperty('id'));
        $this->assertEquals($user->email, $propertyHolder->getProperty('email'));
        $this->assertEquals($user->login, $propertyHolder->getProperty('login'));
        $this->assertEquals($user->phone, $propertyHolder->getProperty('phone'));
        $this->assertEquals($user->fio, $propertyHolder->getProperty('fio'));
        $this->assertEquals($user->id_prov, $propertyHolder->getProperty('id_prov'));
        $this->assertArraySubset($user->roles->pluck('display_name')->toArray(), $propertyHolder->getProperty('roles'));
    }
}
