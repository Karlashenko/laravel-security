<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core;

use Phrantiques\Security\Core\Properties\Property;
use Phrantiques\Security\Core\Assertions\Assertion;

class Condition
{
    /**
     * @var Property
     */
    private $propertyA;

    /**
     * @var Property
     */
    private $propertyB;

    /**
     * @var Assertion
     */
    private $assertion;

    /**
     * @return Property
     */
    public function getPropertyA(): Property
    {
        return $this->propertyA;
    }

    /**
     * @param Property $propertyA
     *
     * @return $this
     */
    public function setPropertyA(Property $propertyA): Condition
    {
        $this->propertyA = $propertyA;

        return $this;
    }

    /**
     * @return Property
     */
    public function getPropertyB(): Property
    {
        return $this->propertyB;
    }

    /**
     * @param Property $propertyB
     *
     * @return $this
     */
    public function setPropertyB(Property $propertyB): Condition
    {
        $this->propertyB = $propertyB;

        return $this;
    }

    /**
     * @return Assertion
     */
    public function getAssertion(): Assertion
    {
        return $this->assertion;
    }

    /**
     * @param Assertion $assertion
     *
     * @return $this
     */
    public function setAssertion(Assertion $assertion): Condition
    {
        $this->assertion = $assertion;

        return $this;
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return $this->assertion->assert($this->propertyA->getValue(), $this->propertyB->getValue());
    }
}
