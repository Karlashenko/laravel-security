<?php

declare(strict_types=1);

use App\ResourceDescriptions\Properties\PropertyHydrator;
use Tests\TestCase;

class DynamicPropertyTest extends TestCase
{
    public function testRead(): void
    {
        $object = new \StdClass();
        $object->id = 100;

        $property = (new \App\ResourceDescriptions\Properties\DynamicReadableProperty(function ($object) {
            return $object->id * 2;
        }))->withLabel('Идентификатор');

        $this->assertEquals(200, $property->read($object, new PropertyHydrator()));
        $this->assertEquals('Идентификатор', $property->label());
    }

    public function testWrite(): void
    {
        $object = new \StdClass();

        $property = new \App\ResourceDescriptions\Properties\DynamicWritableReadableProperty(function ($object, $value) {
            $object->id = $value * 2;
        }, function () {});

        $property->write($object, 100);

        $this->assertEquals(200, $object->id);
    }
}
