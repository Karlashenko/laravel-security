<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Properties;

class ObjectProperty implements Property
{
    /**
     * @var PropertyHolder
     */
    private $propertyHolder;

    /**
     * @var string
     */
    private $key;

    public function __construct(PropertyHolder $propertyHolder, string $key)
    {
        $this->propertyHolder = $propertyHolder;
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->propertyHolder->getProperty($this->key);
    }
}
