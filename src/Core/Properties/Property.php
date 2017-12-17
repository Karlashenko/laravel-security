<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Properties;

interface Property
{
    /**
     * @return mixed
     */
    public function getValue();
}
