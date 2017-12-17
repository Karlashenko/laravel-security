<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Properties;

class EntityProperty implements Property
{
    /**
     * @var PropertyHolder
     */
    private $propertyHolder;

    /**
     * @var string
     */
    private $key;

    /**
     * Create a new EntityProperty instance.
     *
     * @param PropertyHolder $propertyHolder
     * @param string         $key
     */
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
