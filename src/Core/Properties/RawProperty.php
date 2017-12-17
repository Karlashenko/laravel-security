<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Properties;

class RawProperty implements Property
{
    private $value;

    /**
     * Create a new RawProperty instance.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
