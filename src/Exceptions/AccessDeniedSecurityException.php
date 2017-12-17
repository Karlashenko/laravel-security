<?php

declare(strict_types=1);

namespace Phrantiques\Security\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class AccessDeniedSecurityException extends SecurityException
{
    public function __construct(string $message = 'Access denied', $code = Response::HTTP_FORBIDDEN, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
