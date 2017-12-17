<?php

declare(strict_types=1);

use App\ResourceDescriptions\CallingResourceDescription;
use App\ResourceDescriptions\Properties\ReadableProperty;
use App\ResourceDescriptions\Properties\PropertyFactory;
use App\ResourceDescriptions\Properties\ResourceCollectionReadableProperty;
use App\ResourceDescriptions\Properties\ResourceReadableProperty;
use App\ResourceDescriptions\ResourceFactory;
use Tests\TestCase;

class PropertyFactoryTest extends TestCase
{
    public function testFactoryCreatesProperties(): void
    {
        $propertyFactory = new PropertyFactory(new ResourceFactory());

        $property = $propertyFactory->readableProperty('key');
        $this->assertInstanceOf(ReadableProperty::class, $property);

        $property = $propertyFactory->readableResourceCollectionProperty(CallingResourceDescription::class, 'key');
        $this->assertInstanceOf(ResourceCollectionReadableProperty::class, $property);

        $property = $propertyFactory->readableResourceProperty(CallingResourceDescription::class, 'key');
        $this->assertInstanceOf(ResourceReadableProperty::class, $property);

        $property = $propertyFactory->readableDatetimeProperty('key');
        $this->assertInstanceOf(\App\ResourceDescriptions\Properties\DateTimeReadableProperty::class, $property);

        $property = $propertyFactory->readableDateProperty('key');
        $this->assertInstanceOf(\App\ResourceDescriptions\Properties\DateReadableProperty::class, $property);
    }
}
