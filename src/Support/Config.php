<?php

declare(strict_types=1);

namespace Phrantiques\Security\Support;

use Phrantiques\Security\Services\Security;

final class Config
{
    private function __construct()
    {
    }

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return config('security', []);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public static function getPropertyTypeName(string $type): string
    {
        return config("security.property_types.{$type}", '');
    }

    /**
     * @return array
     */
    public static function getAssertions(): array
    {
        return config('security.assertions', []);
    }

    /**
     * @param string $effect
     *
     * @return string
     */
    public static function getEffectName(string $effect): string
    {
        return config('security.effects.' . $effect, '');
    }

    /**
     * @param string $assertion
     *
     * @return string
     */
    public static function getAssertionName(string $assertion): string
    {
        return config("security.assertions.{$assertion}", '');
    }

    /**
     * @return array
     */
    public static function getSubjectEntities(): array
    {
        return self::getEntities(Security::PROPERTY_TYPE_SUBJECT);
    }

    /**
     * @return array
     */
    public static function getResourceEntities(): array
    {
        return self::getEntities(Security::PROPERTY_TYPE_RESOURCE);
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public static function getEntities(string $type): array
    {
        $key = "security.entities.{$type}";

        return config($key, []);
    }

    /**
     * @param string $type
     * @param string $entity
     *
     * @return array
     */
    public static function getEntityProperties(string $type, string $entity): array
    {
        $key = "security.entities.{$type}.{$entity}.properties";

        return config($key, []);
    }

    /**
     * @return array
     */
    public static function getActions(): array
    {
        return config('security.actions', []);
    }

    /**
     * @return array
     */
    public static function getAlgorithms(): array
    {
        return config('security.algorithms', []);
    }

    /**
     * @param string $class
     *
     * @return string|null
     */
    public static function getPropertyHolder(string $class): ?string
    {
        $key = "security.property_holders.{$class}";

        return config($key);
    }

    /**
     * @param string $type
     * @param string $resource
     *
     * @return string
     */
    public static function getResourceName(string $resource): string
    {
        return self::getEntityName(Security::PROPERTY_TYPE_RESOURCE, $resource);
    }

    /**
     * @param string $type
     * @param string $resource
     *
     * @returnstring
     */
    public static function getSubjectName(string $subject): string
    {
        return self::getEntityName(Security::PROPERTY_TYPE_SUBJECT, $subject);
    }

    /**
     * @param string $type
     * @param string $subject
     *
     * @return string
     */
    public static function getEntityName(string $type, string $subject): string
    {
        $key = "security.entities.{$type}.{$subject}.name";

        return config($key, '');
    }

    /**
     * @param string $resource
     * @param string $property
     *
     * @return string
     */
    public static function getResourcePropertyName(string $resource, string $property): string
    {
        return static::getPropertyName(Security::PROPERTY_TYPE_RESOURCE, $resource, $property);
    }

    /**
     * @param string $resource
     * @param string $property
     *
     * @return string
     */
    public static function getSubjectPropertyName(string $resource, string $property): string
    {
        return static::getPropertyName(Security::PROPERTY_TYPE_SUBJECT, $resource, $property);
    }

    /**
     * @param string $type
     * @param string $resource
     * @param string $property
     *
     * @return string
     */
    public static function getPropertyName(string $type, string $resource, string $property): string
    {
        $key = "security.entities.{$type}.{$resource}.properties.{$property}";

        return config($key, '');
    }

    /**
     * @param string $action
     *
     * @return string
     */
    public static function getActionName(string $action): string
    {
        $key = "security.actions.{$action}";

        return config($key, '');
    }
}
