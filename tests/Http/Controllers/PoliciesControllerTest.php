<?php

declare(strict_types=1);

use Tests\TestCase;

class PoliciesControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $this->be(\App\Models\User::whereUserRole(App\Models\User::ROLE_ADMIN)->first());

        $response = $this->get(route('security.policies.index'));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore(): void
    {
        $this->be(\App\Models\User::whereUserRole(App\Models\User::ROLE_ADMIN)->first());

        $data = [
            'name'       => 'Чтение полей Вызова ' . time(),
            'subject'    => 'App\Models\User',
            'resource'   => 'App\Models\Callings\Calling',
            'action'     => 'read',
            'algorithm'  => 'Phrantiques\Security\Core\Algorithms\DenyOverrides',
            'properties' => ['id', 'created_at', 'address', 'status'],
            'rules'      => [1, 2],
        ];

        $response = $this->withSession($data)->post(route('security.policies.store'), $data);
        $this->assertEquals(302, $response->getStatusCode());
    }
}
