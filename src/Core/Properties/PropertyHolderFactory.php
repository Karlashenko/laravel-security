<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Properties;

use App\Models\User;
use Phrantiques\Security\Support\Config;

class PropertyHolderFactory
{
    /**
     * @param mixed $object
     *
     * @return PropertyHolder
     */
    public static function make($object): PropertyHolder
    {
        $propertyHolderClass = Config::getPropertyHolder(get_class($object));

        return new $propertyHolderClass($object);
    }
}
