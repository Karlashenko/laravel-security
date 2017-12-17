<?php

declare(strict_types=1);

namespace Phrantiques\Security\Contracts;

use Phrantiques\Security\Services\Security;

interface SecurityServiceAware
{
    /**
     * @param Security $security
     *
     * @return void
     */
    public function setSecurityService(Security $security): void;
}
