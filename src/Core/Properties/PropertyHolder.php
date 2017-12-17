<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Properties;

class PropertyHolder
{
    /**
     * @var mixed
     */
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * @param string $propertyName
     *
     * @return mixed
     */
    public function getProperty(string $propertyName)
    {
        $propertyGetterMethod = $this->propertyGetterMethodName($propertyName);

        if (method_exists($this, $propertyGetterMethod)) {
            return $this->{$propertyGetterMethod}();
        }

        return $this->object->{$propertyName};
    }

    protected function propertyGetterMethodName(string $propertyName): string
    {
        return 'get' . ucfirst(camel_case($propertyName));
    }
}
