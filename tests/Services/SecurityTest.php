<?php

declare(strict_types=1);

use Tests\TestCase;
use App\Models\User;
use App\Models\Callings\Calling;
use Phrantiques\Security\Services\Security;

class SecurityTest extends TestCase
{
    public function testIsAuthorized(): void
    {
        $security = new Security();
        $security->isAuthorized(new User(), new Calling(), Security::ACTION_READ, ['id']);
    }
}
