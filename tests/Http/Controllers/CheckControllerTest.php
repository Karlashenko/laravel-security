<?php

declare(strict_types=1);

use Tests\TestCase;

class CheckControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $this->be(\App\Models\User::whereUserRole(App\Models\User::ROLE_ADMIN)->first());

        $response = $this->get(route('security.check.index'));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testHandle(): void
    {
        $this->be(\App\Models\User::whereUserRole(App\Models\User::ROLE_ADMIN)->first());

        $response = $this->post(route('security.check.handle'), ['user_id' => \Illuminate\Support\Facades\Auth::user()->id]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
