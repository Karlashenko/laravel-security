<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Hydrators;

use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Condition;
use Phrantiques\Security\Core\Properties\Property;
use Phrantiques\Security\Core\Properties\RawProperty;
use Phrantiques\Security\Core\Properties\ObjectProperty;
use Phrantiques\Security\Core\Assertions\AssertionFactory;
use Phrantiques\Security\Core\PropertyHolders\PropertyHolderFactory;

class ConditionHydrator implements Hydrator
{
    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var mixed
     */
    private $resource;

    /**
     * Create a new ConditionHydrator instance.
     *
     * @param mixed $subject
     * @param mixed $resource
     */
    public function __construct($subject, $resource)
    {
        $this->subject = $subject;
        $this->resource = $resource;
    }

    /**
     * @param array     $data
     * @param Condition $condition
     *
     * @return void
     * @throws \RuntimeException
     * @throws \ReflectionException
     */
    public function hydrate(array $data, $condition): void
    {
        $this->validateConditionDataKeys($data);
        $this->validatePropertyDataKeys($data['propertyA']);
        $this->validatePropertyDataKeys($data['propertyB']);

        $propertyA = $this->makeProperty($data['propertyA']);
        $propertyB = $this->makeProperty($data['propertyB']);

        $assertion = AssertionFactory::make($data['assertion']);

        $condition->setPropertyA($propertyA)
                  ->setPropertyB($propertyB)
                  ->setAssertion($assertion);
    }

    /**
     * @param array $data
     *
     * @return Property
     * @throws \ReflectionException
     * @throws \RuntimeException
     */
    private function makeProperty(array $data): Property
    {
        if ($data['type'] === Security::PROPERTY_TYPE_RAW) {
            return new RawProperty($data['value']);
        }

        if ($data['type'] === Security::PROPERTY_TYPE_SUBJECT) {
            $subjectPropertyHolder = PropertyHolderFactory::make($this->subject);
            return new ObjectProperty($subjectPropertyHolder, $data['key']);
        }

        if ($data['type'] === Security::PROPERTY_TYPE_RESOURCE) {
            $resourcePropertyHolder = PropertyHolderFactory::make($this->resource);
            return new ObjectProperty($resourcePropertyHolder, $data['key']);
        }

        throw new \RuntimeException(sprintf('Unknown property type "%s"', $data['type']));
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws \RuntimeException
     */
    private function validateConditionDataKeys(array $data): void
    {
        $requiredKeys = ['assertion', 'propertyA', 'propertyB'];

        foreach ($requiredKeys as $requiredKey) {
            if (array_key_exists($requiredKey, $data)) {
                continue;
            }

            throw new \RuntimeException(sprintf('Missing required key "%s" in condition data.', $requiredKey));
        }
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws \RuntimeException
     */
    private function validatePropertyDataKeys(array $data): void
    {
        $requiredKeys = ['type', 'entity', 'key', 'value'];

        if ($data['type'] === Security::PROPERTY_TYPE_RAW) {
            unset($requiredKeys[1], $requiredKeys[2]);
        } else {
            unset($requiredKeys[3]);
        }

        foreach ($requiredKeys as $requiredKey) {
            if (array_key_exists($requiredKey, $data)) {
                continue;
            }

            throw new \RuntimeException(sprintf('Missing required key "%s" in property data.', $requiredKey));
        }
    }
}
