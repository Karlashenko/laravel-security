<?php

declare(strict_types=1);

use App\ResourceDescriptions\Properties\PropertyHydrator;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    public function testRead(): void
    {
        $object = new \StdClass();
        $object->id = 100;

        $property = (new \App\ResourceDescriptions\Properties\ReadableProperty('id'))->withLabel('Идентификатор');

        $this->assertEquals(100, $property->read($object, new PropertyHydrator()));
        $this->assertEquals('Идентификатор', $property->label());
    }
}
