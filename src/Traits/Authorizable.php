<?php

declare(strict_types=1);

namespace Phrantiques\Security\Traits;

use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Algorithms\Algorithm;
use Phrantiques\Security\Exceptions\AccessDeniedSecurityException;

trait Authorizable
{
    public function isAuthorized($resource, string $action, array $properties = null, Algorithm $algorithm = null): bool
    {
        return app('security')->isAuthorized($this, $resource, $action, $properties, $algorithm);
    }

    public function checkCreate($resource, array $properties = [], Algorithm $algorithm = null): void
    {
        $this->checkAuthorized($resource, Security::ACTION_CREATE, $properties, $algorithm);
    }

    public function checkAuthorized($resource, string $action, array $properties = null, Algorithm $algorithm = null): void
    {
        if ($this->isAuthorized($resource, $action, $properties, $algorithm)) {
            return;
        }

        $pattern = '%s has no permission to %s %s';
        $message = sprintf($pattern, get_class($this), $action, get_class($resource));

        throw new AccessDeniedSecurityException($message);
    }
}
