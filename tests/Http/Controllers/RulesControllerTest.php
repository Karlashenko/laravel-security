<?php

declare(strict_types=1);

use Tests\TestCase;

class RulesControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $this->be(\App\Models\User::whereUserRole(App\Models\User::ROLE_ADMIN)->first());

        $response = $this->get(route('security.rules.index'));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
